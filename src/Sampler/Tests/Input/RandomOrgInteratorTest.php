<?php

namespace Sampler\Tests\Input;

use TestTools\TestCase\UnitTestCase;

class RandomOrgIteratorTest extends UnitTestCase
{
    /**
     * @var \Sampler\Input\RandomOrgIterator
     */
    protected $input;

    public function setUp()
    {
        $this->input = $this->get('input.randomorg');
    }

    public function testIterate()
    {
        $count = 0;

        foreach ($this->input as $char) {
            $this->assertInternalType('string', $char);
            $this->assertEquals(1, strlen($char));
            $count++;
        }

        $this->assertEquals(4096, $count);
    }

    /**
     * @expectedException \Sampler\Exception\InvalidArgumentException
     */
    public function testSetLengthNegative()
    {
        $this->input->setLength(-2);
    }

    /**
     * @expectedException \Sampler\Exception\InvalidArgumentException
     */
    public function testSetLengthZero()
    {
        $this->input->setLength(0);
    }

    public function testSetLength()
    {
        $this->input->setLength(591);

        $this->assertEquals(591, $this->input->getLength());
    }
}