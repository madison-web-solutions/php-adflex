<?php

namespace MadisonSolutions\Adflex;

use Webmozart\Assert\Assert;

/**
 * Represents a request that can be made to the Adflex API
 */
class Request extends ImmutableBaseObj
{
    /**
     * Create a Request object instance
     *
     * @param string $method The method for the HTTP request - either 'get' or 'post'
     * @param string $path The path to the API endpoint, not including the domain, eg v2/ahpp/authorisation/token
     * @param array Optional array of data to send with the request
     */
    public function __construct(string $method, string $path, ?array $params = null)
    {
        $this->populate([
            'method' => $method,
            'path' => $path,
            'params' => $params ?? [],
        ]);
    }

    /**
     * Populate this object with data
     *
     * @param array $data Array of payment data
     * @throws InvalidArgumentException If the data is not valid
     */
    public function populate(array $data)
    {
        Assert::stringNotEmpty($data['method'] ?? null);
        $data['method'] = strtolower($data['method']);
        Assert::oneOf($data['method'] ?? null, ['get', 'post']);
        Assert::stringNotEmpty($data['path'] ?? null);
        Assert::isArray($data['params'] ?? null);

        $this->data = [
            'method' => $data['method'],
            'path' => trim($data['path'], '/'),
            'params' => $data['params'],
        ];
    }
}
