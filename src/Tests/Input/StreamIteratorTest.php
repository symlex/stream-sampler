<?php

namespace Sampler\Tests\Input;

use TestTools\TestCase\UnitTestCase;

class StreamIteratorTest extends UnitTestCase
{
    /**
     * @var \Sampler\Input\StreamIterator
     */
    protected $input;

    public function setUp()
    {
        $this->input = $this->get('input.stream');
    }

    public function testIterate()
    {
        $count = 0;
        $result = '';

        foreach($this->input as $char) {
            $this->assertInternalType('string', $char);
            $this->assertEquals(1, strlen($char));
            $result .= $char;
            $count++;
        }

        $this->assertEquals(33, $count);
        $this->assertEquals('cP1a52opUY1OSDx1Q13b8vwuNt358bnw8', $result);
    }
}