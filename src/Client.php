<?php

namespace MadisonSolutions\Adflex;

use Firebase\JWT\JWT;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;

/**
 * Object used to interact with the Adflex API - IE send requests and receive responses
 */
class Client
{
    /**
     * The base URL for API requests
     *
     * @var string
     */
    protected $api_url;

    /**
     * The access key provided by Adflex for API requests
     *
     * @var string
     */
    protected $access_key;

    /**
     * The APG ID provided by Adflex for the account
     *
     * @var string
     */
    protected $apg_id;

    /**
     * The access key provided by Adflex for API requests
     *
     * @var string
     */
    protected $secret_key;

    /**
     * Object which will be used for logging debug/error messages
     *
     * @var Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Create an instance of the Adflex helper object
     *
     * @param string $api_url The base URL for API requests, eg https://api.adflex.co.uk
     * @param string $access_key The access key provided by Adflex for API requests
     * @param string $apg_id The APG ID provided by Adflex for the account
     * @param string $secret_key The access key provided by Adflex for API requests
     * @param Psr\Log\LoggerInterface $logger Object which will be used for logging debug/error messages
     */
    public function __construct($api_url, $access_key, $apg_id, $secret_key, $logger)
    {
        $this->api_url = $api_url;
        $this->access_key = $access_key;
        $this->apg_id = $apg_id;
        $this->secret_key = $secret_key;
        $this->logger = $logger;
    }

    /**
     * Perform a GET request to the Adflex API
     *
     * @param string $path The path to the API endpoint, not including the domain, eg v2/ahpp/authorisation/token
     * @param array $params Optional array of parameters (which will be appended to the URL as a query string)
     * @return MadisonSolutions\Adflex\Response The response from Adflex
     */
    public function get(string $path, ?array $params = null)
    {
        $request = new Request('get', $path, $params);
        return $this->request($request);
    }

    /**
     * Perform a POST request to the Adflex API
     *
     * @param string $path The path to the API endpoint, not including the domain, eg v2/ahpp/authorisation/token
     * @param array $params Optional array of parameters (which will be sent as JSON in the request body)
     * @return MadisonSolutions\Adflex\Response The response from Adflex
     */
    public function post(string $path, ?array $params = null)
    {
        $request = new Request('post', $path, $params);
        return $this->request($request);
    }

    /**
     * Create a JWT token for the URL, used in authentication
     *
     * @param string $url The URL of the request
     * @return string The JWT token
     */
    protected function makeJwtToken($url)
    {
        return JWT::encode([
            'jti' => Uuid::uuid4(),
            'aud' => $url,
            'iss' => 'Adflex',
            'iat' => time(),
        ], $this->secret_key);
    }

    /**
     * Perform a request to the Adflex API
     *
     * @param MadisonSolutions\Adflex\Response $request The request to perform
     * @return MadisonSolutions\Adflex\Response The response from Adflex
     */
    public function request(Request $request)
    {
        // Create curl handle
        $curl = curl_init();

        // Construct url
        $url = "{$this->api_url}/{$request->path}";
        if ($request->method == 'get' && ! empty($request->params)) {
            $url = $url . '?' . http_build_query($request->params);
        }

        // Generate auth token
        $token = $this->makeJwtToken($url);

        // Set curl settings
        $curl_options = [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json",
                "Authorization: Bearer {$token}",
                "x-request-apgID: {$this->apg_id}",
                "x-request-accessKey: {$this->access_key}",
            ]
        ];
        if ($request->method == 'post') {
            $curl_options[CURLOPT_CUSTOMREQUEST] = 'POST';
            $curl_options[CURLOPT_POSTFIELDS] = json_encode($request->params);
        }
        curl_setopt_array($curl, $curl_options);

        $this->logger->debug("Sending {$request->method} to {$url} " . ($curl_options[CURLOPT_POSTFIELDS] ?? ''));

        // Execute the request and capture the response, http status code and any curl error message
        $response = new Response();
        $response->raw = curl_exec($curl);
        $response->http_code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        $response->curl_err = curl_error($curl);

        // Close the connection
        curl_close($curl);

        // Check for a curl error
        if ($response->curl_err) {
            throw new ClientException("Curl error", $request, $response);
        }

        $this->logger->debug("Response {$response->http_code}: $response->raw");

        // The response should be a json object
        $response_decoded = json_decode($response->raw, true);
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new ClientException("Json decoding error: " . json_last_error_msg(), $request, $response);
        }
        if (! is_array($response_decoded)) {
            throw new ClientException("Json decoding error: expected array as response but got " . gettype($response_decoded), $request, $response);
        }

        /*
        Normal response:
        {
            "subCode":50001,
            "statusMessage":"OK",
            "responseObject":{
                ... request-specific response data here
            }
        }

        Timeout response:
        {
            "subCode":54211,
            "statusMessage": "Endpoint request timed out",
            "responseObject":null
        }
        */

        // Check that the subCode, statusMessage and responseObject are present
        if (! array_key_exists('statusMessage', $response_decoded)) {
            throw new ClientException("Malformed response - statusMessage is missing", $request, $response);
        }
        $response->status = strtolower($response_decoded['statusMessage']);

        if (! array_key_exists('subCode', $response_decoded)) {
            throw new ClientException("Malformed response - subCode is missing", $request, $response);
        }
        $response->sub_code = strtolower($response_decoded['subCode']);

        if (! array_key_exists('responseObject', $response_decoded)) {
            throw new ClientException("Malformed response - responseObject is missing", $request, $response);
        }
        $response->data = $response_decoded['responseObject'] ?? [];

        // Check that the responseObject is an array (note that null value is already cast to null above)
        if (! is_array($response->data)) {
            throw new ClientException("Malformed response - expected array as responseObject but got " . gettype($response->data), $request, $response);
        }

        // Check that we've got the expected values for the status message and subcode
        if ($response->status != 'ok' || $response->sub_code != '50001') {
            throw new ClientException("Error response: {$response->status}:{$response->sub_code}", $request, $response);
        }

        // Return only the inner responseObject data which is specific to the request
        return $response->data;
    }
}
