<?php

namespace Sampler\Input;

use IteratorAggregate;
use Sampler\Exception\InvalidArgumentException;

abstract class RandomIterator implements IteratorAggregate
{
    private $length = 4096;

    /**
     * @param int $length
     * @throws InvalidArgumentException
     */
    public function setLength ($length) {
        if($length < 1) {
            throw new InvalidArgumentException('Length must be a positive integer');
        }

        $this->length = (int) $length;
    }

    /**
     * @return int
     */
    public function getLength () {
        return $this->length;
    }

    abstract public function getIterator();
}