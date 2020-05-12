<?php

namespace MadisonSolutions\Adflex;

use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class Adflex
{
    /**
     * Helper object which will be used for logging debug/error messages
     *
     * @var Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Helper object used for making API calls
     *
     * @var MadisonSolutions\Adflex\Client
     */
    protected $client;

    /**
     * Create an instance of the Adflex helper object
     *
     * @param string $api_url The base URL for API requests, eg https://api.adflex.co.uk
     * @param string $access_key The access key provided by Adflex for API requests
     * @param string $apg_id The APG ID provided by Adflex for the account
     * @param string $secret_key The access key provided by Adflex for API requests
     * @param Psr\Log\LoggerInterface $logger Object which will be used for logging debug/error messages
     */
    public function __construct(string $api_url, string $access_key, string $apg_id, string $secret_key, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->client = new Client($api_url, $access_key, $apg_id, $secret_key, $logger);
    }

    /**
     * Get information about a token
     *
     * Retrieve information about the given token via an API call to tokens/{token}
     *
     * @param string $token The token string
     * @return array Array of token information
     * @throws MadisonSolutions\Adflex\ClientException If there is an error during the API call
     */
    public function getTokenInfo(string $token)
    {
        return $this->client->get("v2/tokens/{$token}");
    }

    /**
     * Create a new Adflex session for the given PaymentAttempt
     *
     * Makes an API call to ahpp/session with data from the PaymentAttempt object, and returns the session id
     *
     * @param MadisonSolutions\Adflex\PaymentAttempt $attempt A PaymentAttempt object containing details about the payment
     * @return string The session id, if successful
     * @throws MadisonSolutions\Adflex\ClientException If there is an error during the API call
     * @throws Exception If the session could not be created for some other reason
     */
    public function startSession(PaymentAttempt $attempt) : string
    {
        $payload = [
            'transactionGUID' => $attempt->guid,
            'reference' => $attempt->ref,
            'ttlSeconds' => 14400,
            'amount' => [
                'currency' => $attempt->currency,
                'value' => (string) $attempt->amount, // Not a mistake - Adflex really do want the amount as a string - No idea why
            ],
            'tokenLifetime' => [
                'saveCardOption' => "ShowUnticked",
                'ttlDays' => 90,
            ],
            'description' => $attempt->description,
            'tdsCheck' => 'Default', // 3DSecure
            'cvcCheck' => 'Default', // 3-digit CVC code on back of card
            'avsCheck' => 'Default', // Address Verification Service
        ];

        $additional_fields = [];
        $extra_fields_map = [
            'billing_street' => 'BillingStreet1',
            'billing_postcode' => 'BillingPostcode',
            'billing_country_code' => 'BillingCountryCode',
        ];
        foreach ($extra_fields_map as $field_name => $mapped_field_name) {
            $value = $attempt->$field_name;
            if (is_null($value)) {
                continue;
            }
            $additional_fields[] = [
                'name' => $mapped_field_name,
                'mapTo' => $mapped_field_name,
                'type' => "string",
                'defaultValue' => $value,
                'required' => true,
                'readOnly' => true,
                'visible' => false,
                'labels' => [
                    [
                        'language' => "enGB",
                        'value' => $mapped_field_name,
                    ],
                ],
                'validationMessages' => [
                    [
                        'language' => "enGB",
                        'value' => "{$mapped_field_name} is required",
                    ],
                ]
            ];
        }
        if (! empty($additional_fields)) {
            $payload['additionalFields'] = $additional_fields;
        }

        $response = $this->client->post('v2/ahpp/session', $payload);

        /* Example response
            {
                "sessionID":"sn_T9sPrzjW0g72NlntiKfS",
                "transactionGUID":"76802db7-f77f-4db4-9d22-a242a9554b3a",
                "ttlSeconds":14400
            }
        */

        $session_id =  $response['sessionID'] ?? null;
        if (empty($session_id)) {
            throw new \Exception("Failed to obtain Adflex session id");
        }

        return $session_id;
    }


    /**
     * Try to capture an Adflex payment (take the money) using a saved token
     *
     * Try to capture the funds for the given PaymentAttempt object using the given saved reusable token.
     * Will make an API call to transactions/authorisation/token.
     * Returns a CaptureResult object with the result.
     * Note if there is an error during the API call, it will be caught and error info saved in the returned CaptureResult.
     *
     * @param MadisonSolutions\Adflex\PaymentAttempt $attempt The PaymentAttempt object with details about the payment
     * @param string $token The saved reusable token to collect payment with, collected originally from the AHPP javascript widget
     * @param string $last_4_digits The last 4 digits of the card
     * @param string $cvc The CVC code for the card
     * @return MadisonSolutions\Adflex\CaptureResult Result of the capture attempt
     */
    public function capturePaymentUsingSavedToken(PaymentAttempt $attempt, string $token, string $last_4_digits, string $cvc) : CaptureResult
    {
        // https://my.adflex.co.uk/api-documentation#operation/authorisetoken
        $payload = [
            'amount' => [
                'currency' => 'GBP',
                'value' => (string) $attempt->amount, // why a string?
            ],
            'cardDetails' => [
                'token' => $token,
                'cardLast4Digits' => $last_4_digits,
                'csc' => $cvc,
            ],
            'transactionDetails' => [
                'reference' => $attempt->ref,
                'transactionGUID' => $attempt->guid,
                'type' => 'Sale', // ThreeDSSale ?
                'processMode' => 'AuthAndSettle',
                'CaptureMode' => 'ECOMM',
            ],
        ];

        try {
            $response = $this->client->post('/v2/transactions/authorisation/token', $payload);
        } catch (ClientException $e) {
            return $this->processCapturePaymentClientException($attempt, $e);
        }

        return $this->processCapturePaymentResponse($attempt, $response);
    }

    /**
     * Try to capture an Adflex payment (take the money) using a new token
     *
     * Try to capture the funds for the given PaymentAttempt object using the given token.
     * Will make an API call to ahpp/authorisation/token.
     * Returns a CaptureResult object with the result.
     * Note if there is an error during the API call, it will be caught and error info saved in the returned CaptureResult.
     *
     * @param MadisonSolutions\Adflex\PaymentAttempt $payment The PaymentAttempt object with details about the payment
     * @param string $token The token to collect payment with, collected from the AHPP javascript widget
     * @return MadisonSolutions\Adflex\CaptureResult Result of the capture attempt
     */
    public function capturePaymentUsingNewToken(PaymentAttempt $attempt, string $token) : CaptureResult
    {
        // https://my.adflex.co.uk/api-documentation#operation/ahppauthorisetoken
        $payload = [
            'amount' => [
                'currency' => 'GBP',
                'value' => (string) $attempt->amount, // why a string?
            ],
            'cardDetails' => [
                'token' => $token,
            ],
            'transactionDetails' => [
                'reference' => $attempt->ref,
                'transactionGUID' => $attempt->guid,
                'type' => 'ThreeDSSale',
                'processMode' => 'AuthAndSettle',
                'CaptureMode' => 'ECOMM',
            ],
        ];

        try {
            $response = $this->client->post('v2/ahpp/authorisation/token', $payload);
        } catch (ClientException $e) {
            return $this->processCapturePaymentClientException($attempt, $e);
        }

        return $this->processCapturePaymentResponse($attempt, $response);
    }

    /**
     * Handle a ClientException thrown during an attempt to capture payment
     *
     * @param MadisonSolutions\Adflex\PaymentAttempt $payment The PaymentAttempt object
     * @param MadisonSolutions\Adflex\ClientException $e The exception thrown during the capture attempt
     * @return MadisonSolutions\Adflex\CaptureResult Result of the capture attempt
     */
    protected function processCapturePaymentClientException(PaymentAttempt $attempt, ClientException $e) : CaptureResult
    {
        $msg = $e->getMessage();
        $this->logger->error($msg, ['attempt' => $attempt, 'request' => $e->request, 'response' => $e->response]);

        $result = new CaptureResult();
        $result->status = 'error';
        $result->error_msg = $msg;
        $result->payment_taken = 'uncertain';
        return $result;
    }

    /**
     * Handle the response from an attempt to capture payment
     *
     * @param MadisonSolutions\Adflex\PaymentAttempt $payment The PaymentAttempt object
     * @param array $response The inner response data from the Adflex API call
     * @return MadisonSolutions\Adflex\CaptureResult Result of the capture attempt
     */
    protected function processCapturePaymentResponse(PaymentAttempt $attempt, array $response) : CaptureResult
    {
        /*
        Example Authorised response
        {
            "statusCode":"Authorised",
            "amount":{
                "currency":"GBP",
                "value":"7500"
            },
            "cardDetails":{
                "tokenType":"Reusable",
                "token":"B5FD7861-0693-4C1E-89B7-821794098512",
                "issuer":"UNKNOWN",
                "scheme":"VISA",
                "cardType":"CREDIT",
                "cardLast4Digits":"5556",
                "schemeCode":"52021",
                "cscAvsResponse":{
                    "cscStatus":"Unchecked",
                    "postCodeStatus":"Unchecked",
                    "addressStatus":"Unchecked"
                },
                "enhancedDataType":"Level1"
            },
            "transactionDetails":{
                "schemeReferenceData":"SRD484080143",
                "authCode":"75180",
                "credentialsOnFile":{
                    "storedPaymentDetailsIndicator":"Na",
                    "cardAcceptorCardHolderAgreement":"Na",
                    "initialTransactionGUID":"",
                    "cofDataRaw":"NNNN"
                },
                "threeDSResult":{
                    "transactionStatus":null,
                    "dateTime":null,
                    "authenticationValue":null,
                    "eci":null,
                    "xID":null,
                    "protocolVersion":null,
                    "serverTransactionID":null,
                    "veResEnrollmentStatus":null,
                    "cavvAlgorithm":null
                },
                "sessionID":"sn_pk2lhBOfgs5eYMvV3ITW",
                "messageNumber":"18",
                "terminalNumber":"22620042",
                "reference":"AT2005pwfybe",
                "transactionGUID":"3efdca2f-d2b2-49bb-8bf5-892c50638248",
                "processedDate":"2020-05-04T10:24:53Z",
                "merchantNumber":"22048122",
                "captureMode":"ECOMM"
            },
            "additionalFields":[
                {"name":"cardHolderName","value":"MR DANIEL HOWARD"},
                {"name":"saveCard","value":"true"}
            ]
        }

        Example Declined Response
        {
            "statusCode": "Declined",
            "amount": {
                "currency": "GBP",
                "value": "3786"
            },
            "cardDetails": {
                "token": "E13BD5EC-B011-457C-B392-E585C4496C08",
                "issuer": "UNKNOWN",
                "scheme": "VISA",
                "cardType": "CREDIT",
                "cardLast4Digits": "8889",
                "schemeCode": "52021",
                "cscAvsResponse": {
                    "cscStatus": "Matched",
                    "postCodeStatus": "Matched",
                    "addressStatus": "Unchecked"
                },
                "enhancedDataType": "NotSet"
            },
            "transactionDetails": {
                "schemeReferenceData": "SRD 113964188",
                "authCode": "",
                "credentialsOnFile": {
                    "storedPaymentDetailsIndicator": "Na",
                    "cardAcceptorCardHolderAgreement": "Na",
                    "initialTransactionGUID": "",
                    "cofDataRaw": "NNNN"
                },
                "threeDSResult": {
                    "transactionStatus": null,
                    "dateTime": null,
                    "authenticationValue": null,
                    "eci": null,
                    "xID": null,
                    "protocolVersion": null,
                    "serverTransactionID": null,
                    "veResEnrollmentStatus": null,
                    "cavvAlgorithm": null
                },
                "messageNumber": "2",
                "terminalNumber": "22620042",
                "reference": "AT1912dqfzen",
                "transactionGUID": "638ef294-612d-4ad2-8dd4-3b1b41a61fd1",
                "processedDate": "2019-12-05T08:47:50Z",
                "merchantNumber": "1111358033202",
                "captureMode": "ECOMM"
            },
            "additionalFields": null
        }
        */

        $result = new CaptureResult();

        // Save the payment method and last 4 digits from the response, if present
        $result->scheme = mb_convert_case($response['cardDetails']['scheme'], MB_CASE_TITLE);
        $result->card_type = mb_convert_case($response['cardDetails']['cardType'], MB_CASE_TITLE);
        $result->last_4_digits = $response['cardDetails']['cardLast4Digits'];

        // Check the outcome of the payment
        $status_code = $response['statusCode'] ?? 'none';
        switch ($status_code) {
            case 'Authorised':
            case 'AuthorisedOnly':
            case 'Settled':
                $result->status = 'authorised';
                $result->payment_taken = 'yes';
                break;
            case 'Declined':
            case 'ReferralA':
            case 'MerchantRejected':
                $result->status = 'declined';
                $result->error_msg = "The payment was declined";
                $result->payment_taken = 'no';
                break;
            case 'Cancelled':
                $result->status = 'cancelled';
                $result->error_msg = 'The transaction was cancelled';
                $result->payment_taken = 'no';
                break;
            case 'CardRegistered':
            case 'Validated':
                $this->logger->error("Got a {$status_code} response from Adflex on a capture attempt - that makes no sense");
                $result->status = 'error';
                $result->error_msg = 'Unexpected response from payment gateway';
                $result->payment_taken = 'no';
                break;
            case 'MerchantAccepted':
            case 'MerchantPending':
                $this->logger->error("Got a {$status_code} response from Adflex on a capture attempt - that makes no sense");
                $result->status = 'error';
                $result->error_msg = 'Unexpected response from payment gateway';
                $result->payment_taken = 'uncertain';
                break;
            default:
                $this->logger->error("Unexpected statusCode from Adflex '{$status_code}'");
                $result->status = 'error';
                $result->error_msg = 'Unexpected response from payment gateway';
                $result->payment_taken = 'uncertain';
                break;
        }

        // Check the details specified in the response match those of the payment attempt
        // These checks should always pass because the values come directly from the request
        // So if any are wrong we've either got an error in the code or the payment gateway is having some serious problems

        // Utility function to handle an error
        // Logs the error message, sets status=error and saves the error message into the metadata on the Payment
        $error = function ($msg) use ($result) {
            $this->logger->error($msg);
            $result->status = 'error';
            $result->error_msg = $msg;
        };

        $currency = $response['amount']['currency'] ?? 'none';
        if ($currency != $attempt->currency) {
            $error("Unexpected payment currency '{$currency}' expected '{$attempt->currency}'");
        }
        $amount = $response['amount']['value'] ?? 'none';
        if ($amount != "{$attempt->amount}") {
            $error("Unexpected payment amount '{$amount}' expected '{$attempt->amount}'");
        }
        $ref = $response['transactionDetails']['reference'] ?? 'none';
        if ($ref != $attempt->ref) {
            $error("Unexpected transaction reference '{$ref}' expected '{$attempt->ref}'");
        }
        $guid = $response['transactionDetails']['transactionGUID'] ?? 'none';
        if ($guid != $attempt->guid) {
            $error("Unexpected transaction reference '{$guid}' expected '{$attempt->guid}'");
        }

        return $result;
    }
}
