<?php

namespace Sampler\Sampler;

use Sampler\Exception\Exception;
use Traversable;

abstract class AbstractSampler
{
    protected $stream = null;

    /**
     * @param Traversable $stream
     */
    public function setStream(Traversable $stream)
    {
        $this->stream = $stream;
    }

    /**
     * @throws Exception
     * @return Traversable
     */
    protected function getStream()
    {
        if (is_null($this->stream)) {
            throw new Exception ('Stream iterator not set');
        }

        return $this->stream;
    }

    /**
     * @param int $size
     * @return array
     */
    abstract public function getSample($size);

    /**
     * @param int $size
     * @return string
     */
    public function getSampleAsString($size)
    {
        $result = $this->getSample($size);

        return join('', $result);
    }
}