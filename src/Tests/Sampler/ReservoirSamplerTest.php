<?php

namespace Sampler\Tests\Sampler;

use TestTools\TestCase\UnitTestCase;
use ArrayIterator;
use Traversable;

class ReservoirSamplerTest extends UnitTestCase
{
    /**
     * @var \Sampler\Sampler\ReservoirSampler
     */
    protected $sampler;

    public function setUp()
    {
        $this->sampler = $this->get('sampler.reservoir');
    }

    protected function getArrayIteratorFixture()
    {
        $inputString = 'THEQUICKBROWNFOXJUMPSOVERTHELAZYDOG';
        $result = new ArrayIterator(str_split($inputString));
        return $result;
    }

    protected function verifySample(Traversable $iterator)
    {
        $maxLoops = 5;

        for ($loop = 0; $loop < $maxLoops; $loop++) {
            $sampleLength = rand(0, 30);

            $this->sampler->setStream($iterator);
            $result = $this->sampler->getSample($sampleLength);

            $this->assertInternalType('array', $result);
            $this->assertCount($sampleLength, $result);

            foreach ($result as $key => $value) {
                $this->assertInternalType('int', $key);
                $this->assertInternalType('string', $value);
            }
        }
    }

    public function testGetSampleFromArrayIterator()
    {
        $input = $this->getArrayIteratorFixture();
        $this->verifySample($input);
    }

    public function testGetOversizedSampleFromArrayIterator()
    {
        $iterator = $this->getArrayIteratorFixture();
        $this->sampler->setStream($iterator);
        $result = $this->sampler->getSample(count($iterator) + 10);

        $this->assertInternalType('array', $result);
        $this->assertCount(count($iterator), $result);
    }

    public function testGetSampleFromRandomByteIterator()
    {
        $input = $this->get('input.randombyte');
        $this->verifySample($input);
    }

    public function testGetSampleFromStreamIterator()
    {
        $input = $this->get('input.stream');
        $this->verifySample($input);
    }
}