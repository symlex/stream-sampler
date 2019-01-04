<?php

namespace Sampler\Input;

use Buzz\Client\ClientInterface;
use Buzz\Message\Request;
use Buzz\Message\Response;
use Sampler\Exception\Exception;
use Sampler\Exception\RequestFailedException;

class RandomOrgIterator extends RandomIterator
{
    private $httpClient;

    /**
     * @param ClientInterface $httpClient For testability reasons, the Buzz HTTP client is used
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return string Random string with a size between 1 und 20 characters
     * @throws Exception If result has unexpected length
     * @throws RequestFailedException If HTTP Request failed
     */
    protected function getRandomString()
    {
        $requestStringCount = ceil($this->getLength() / 20);

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
        $result = substr($result, 0, $this->getLength());

        $resultStringLength = strlen($result);

        // Check if string matches our expectations
        if ($resultStringLength != $this->getLength()) {
            throw new Exception('Invalid response string length: ' . $resultStringLength);
        }

        return $result;
    }
}