<?php

namespace Sampler\Input;

use IteratorAggregate;
use ArrayIterator;

class RandomByteIterator implements IteratorAggregate
{
    private $length;

    /**
     * @param int $length
     */
    public function __construct($length = 4096)
    {
        $this->length = (int)$length;
    }

    private function getRandomString()
    {
        // When using PHP version < 7, this is our best option to get a random binary string
        $randomBytes = openssl_random_pseudo_bytes($this->length);

        // Convert binary string to readable string using base64 encoding
        $result = substr(str_replace(array('+', '/', '='), '', base64_encode($randomBytes)), 0, $this->length);

        return $result;
    }

    public function getIterator()
    {
        return new ArrayIterator(str_split($this->getRandomString()));
    }
}