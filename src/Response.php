<?php

namespace MadisonSolutions\Adflex;

/**
 * Represents a response from the Adflex API
 *
 * The shop platform should not create these objects directly. The intention is that these objects
 * are returned by library methods that initiate API calls.
 */
class Response
{
    /**
     * The raw response body text
     *
     * @var string
     */
    public $raw;

    /**
     * The HTTP status code of the response
     *
     * @var int
     */
    public $http_code;

    /**
     * The CURL error message, if there was an error at the network level
     *
     * @var string
     */
    public $curl_err;

    /**
     * The status returned by Adflex in the 'outer' part of the response, if known
     *
     * Corresponds to the statusMessage field from the top level of JSON response
     *
     * @var string
     */
    public $status;

    /**
     * The code returned by Adflex in the 'outer' part of the response, if known
     *
     * Corresponds to the subCode field from the top level of JSON response
     *
     * @var int
     */
    public $sub_code;

    /**
     * The data returned by Adflex in the 'inner' part of the response, if known
     *
     * Corresponds to the contents of the responseObject field from the top level of the JSON response
     *
     * @var array
     */
    public $data;
}
