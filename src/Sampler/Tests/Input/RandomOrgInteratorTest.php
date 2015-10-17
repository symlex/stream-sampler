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

        $this->assertEquals(20, $count);
    }

    /**
     * @expectedException \Sampler\Exception\InvalidArgumentException
     */
    public function testSetStringLengthMinus10()
    {
        $this->input->setStringLength(-10);
    }

    /**
     * @expectedException \Sampler\Exception\InvalidArgumentException
     */
    public function testSetStringLengthZero()
    {
        $this->input->setStringLength(0);
    }

    /**
     * @expectedException \Sampler\Exception\InvalidArgumentException
     */
    public function testSetStringLength21()
    {
        $this->input->setStringLength(21);
    }

    public function testSetStringLength()
    {
        $this->input->setStringLength(9);

        $this->assertEquals(9, $this->input->getStringLength());
    }
}