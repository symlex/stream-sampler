<?php

namespace Sampler\Sampler;

use Sampler\Exception\InvalidArgumentException;

class ReservoirSampler extends AbstractSampler
{
    /**
     * @param int $size
     * @throws InvalidArgumentException
     * @return array
     */
    public function getSample($size)
    {
        if (!is_int($size) || $size < 0) {
            throw new InvalidArgumentException('Sample size must be a positive integer');
        }

        $result = array();
        $stream = $this->getStream();
        $i = 0;

        foreach ($stream as $item) {
            if ($i < $size) {
                // Fill result array with elements of stream until it's fully populated
                $result[$i] = $item;
            } else {
                // If result array is full, replace random elements with stream elements
                $random = (int)mt_rand(0, $i);

                if ($random < $size) {
                    $result[$random] = $item;
                }
            }

            $i++;
        }

        return $result;
    }
}
