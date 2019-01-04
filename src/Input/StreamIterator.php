<?php

namespace Sampler\Input;

use IteratorAggregate;

class StreamIterator implements IteratorAggregate
{
    private $stream;

    /**
     * @param string $stream
     */
    public function __construct($stream = 'php://stdin')
    {
        $this->stream = $stream;
    }

    public function getIterator()
    {
        $stream = fopen($this->stream, 'r');

        while ($line = fread($stream, 1)) {
            yield $line;
        }

        fclose($stream);
    }
}