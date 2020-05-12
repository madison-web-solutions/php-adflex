<?php

namespace MadisonSolutions\Adflex;

use Exception;

/**
 * Represents an error that occured during an Adflex API call
 */
class ClientException extends Exception
{
    /**
     * The request that was made
     *
     * @var MadisonSolutions\Adflex\Request
     */
    public $request;

    /**
     * The response from Adflex
     *
     * @var MadisonSolutions\Adflex\Response
     */
    public $response;

    /**
     * Create a ClientException object instance
     *
     * @param string $msg Error message
     * @param MadisonSolutions\Adflex\Request $request The request
     * @param MadisonSolutions\Adflex\Response $response The response from Adflex
     */
    public function __construct($msg, Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        parent::__construct($msg, 0, null);
    }
}
