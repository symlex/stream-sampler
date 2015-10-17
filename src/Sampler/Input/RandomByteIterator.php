<?php

namespace Sampler\Input;

use IteratorAggregate;
use ArrayIterator;

class RandomByteIterator implements IteratorAggregate {
    private $length;

    /**
     * @param int $length
     */
    public function __construct($length = 4096) {
        $this->length = (int) $length;
    }

    private function getRandomString () {
        return substr(base64_encode(openssl_random_pseudo_bytes($this->length)), 0, $this->length);
    }

    public function getIterator () {
        return new ArrayIterator(str_split($this->getRandomString()));
    }
}