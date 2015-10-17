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
    private $requestStringLength;

    /**
     * @param ClientInterface $httpClient For testability reasons, the Buzz HTTP client is used
     */
    public function __construct($stringLength, ClientInterface $httpClient)
    {
        $this->setStringLength($stringLength);
        $this->httpClient = $httpClient;
    }

    /**
     * @param int $length
     * @throws InvalidArgumentException
     */
    public function setStringLength($length)
    {
        $length = (int)$length;

        if ($length < 1 || $length > 20000) {
            throw new InvalidArgumentException ('String length must be a positive integer between 1 and 20000');
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
        $requestStringCount = ceil($this->getStringLength() / 20);

        // Uses the random.org Web service, see https://www.random.org/clients/http/
        $request = new Request(
            Request::METHOD_GET,
            '/strings/?num='
            . $requestStringCount
            . '&len=20&digits=on&upperalpha=on&loweralpha=on&unique=on&format=plain&rnd=new',
            'https://www.random.org'
        );

        $response = new Response();

        $this->httpClient->send($request, $response);

        if ($response->getStatusCode() != 200) {
            throw new RequestFailedException($response->getReasonPhrase());
        }

        // Trim whitespace and remove new line characters
        $result = str_replace("\n", '', trim($response->getContent()));

        // Cut off the additional characters
        $result = substr($result, 0, $this->getStringLength());

        $resultStringLength = strlen($result);

        // Check if string matches our expectations
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