<?php

namespace Sampler\Input;

use IteratorAggregate;
use ArrayIterator;
use Buzz\Client\ClientInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Sampler\Exception\Exception;
use Sampler\Exception\InvalidArgumentException;
use Sampler\Exception\RequestFailedException;

class RandomOrgIterator implements IteratorAggregate
{
    private $httpClient;
    private $requestStringLength = 20;

    /**
     * @param ClientInterface $httpClient For testability reasons, the Buzz HTTP client is used
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param int $length
     * @throws InvalidArgumentException
     */
    public function setStringLength($length)
    {
        $length = (int)$length;

        if ($length < 1 || $length > 20) {
            throw new InvalidArgumentException ('String length must be a positive integer between 1 and 20');
        }

        $this->requestStringLength = $length;
    }

    /**
     * @return int
     */
    public function getStringLength()
    {
        return (int)$this->requestStringLength;
    }

    /**
     * @return string Random string with a size between 1 und 20 characters
     * @throws Exception If result has unexpected length
     * @throws RequestFailedException If HTTP Request failed
     */
    private function getRandomString()
    {
        // Uses the random.org Web service, see https://www.random.org/clients/http/
        $request = new Request(
            Request::METHOD_GET,
            '/strings/?num=1&len='
            . $this->getStringLength()
            . '&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new',
            'https://www.random.org'
        );

        $response = new Response();

        $this->httpClient->send($request, $response);

        if ($response->getStatusCode() != 200) {
            throw new RequestFailedException($response->getReasonPhrase());
        }

        $result = trim($response->getContent());
        $resultStringLength = strlen($result);

        if ($resultStringLength != $this->requestStringLength) {
            throw new Exception('Invalid response string length: ' . $resultStringLength);
        }

        return $result;
    }

    public function getIterator()
    {
        return new ArrayIterator(str_split($this->getRandomString()));
    }
}