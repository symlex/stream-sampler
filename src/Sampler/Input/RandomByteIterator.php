<?php

namespace Sampler\Input;

use ArrayIterator;

class RandomByteIterator extends RandomIterator
{
    private function getRandomString()
    {
        $length = $this->getLength();

        // When using PHP version < 7, this is our best option to get a random binary string
        $randomBytes = openssl_random_pseudo_bytes($length);

        // Convert binary string to readable string using base64 encoding
        $result = substr(str_replace(array('+', '/', '='), '', base64_encode($randomBytes)), 0, $length);

        return $result;
    }

    public function getIterator()
    {
        return new ArrayIterator(str_split($this->getRandomString()));
    }
}