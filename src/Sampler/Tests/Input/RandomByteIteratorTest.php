<?php

namespace Sampler\Tests\Input;

use TestTools\TestCase\UnitTestCase;

class RandomByteIteratorTest extends UnitTestCase
{
    /**
     * @var \Sampler\Input\RandomByteIterator
     */
    protected $input;

    public function setUp()
    {
        $this->input = $this->get('input.randombyte');
    }

    public function testIterate()
    {
        $count = 0;
        $result = '';

        foreach ($this->input as $char) {
            $this->assertInternalType('string', $char);
            $this->assertEquals(1, strlen($char));
            $result .= $char;
            $count++;
        }

        $this->assertEquals(4096, $count);

        $secondCount = 0;
        $secondResult = '';

        foreach ($this->input as $char) {
            $this->assertInternalType('string', $char);
            $this->assertEquals(1, strlen($char));
            $secondResult .= $char;
            $secondCount++;
        }

        $this->assertEquals($count, $secondCount);
        $this->assertNotEquals($result, $secondResult);
    }
}