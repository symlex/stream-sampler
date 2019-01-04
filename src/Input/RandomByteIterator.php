<?php

namespace Sampler\Input;

class RandomByteIterator extends RandomIterator
{
    protected function getRandomString()
    {
        $length = $this->getLength();

        // This is our best option to get a random binary string
        $randomBytes = random_bytes($length);

        // Convert binary string to readable string using base64 encoding
        $result = substr(str_replace(array('+', '/', '='), '', base64_encode($randomBytes)), 0, $length);

        return $result;
    }
}