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
    public function testSetStringLength20001()
    {
        $this->input->setStringLength(20001);
    }

    public function testSetStringLength()
    {
        $this->input->setStringLength(591);

        $this->assertEquals(591, $this->input->getStringLength());
    }
}