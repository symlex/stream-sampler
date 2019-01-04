<?php

namespace Sampler\Tests\Input;

use TestTools\TestCase\UnitTestCase;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class SampleCommandTest extends UnitTestCase
{
    /**
     * @var \Sampler\Command\SampleCommand
     */
    protected $command;

    public function setUp()
    {
        $this->command = $this->get('command.sample');
    }

    public function testExecuteInternal()
    {
        $input = new ArrayInput(array('--size' => 10, '--input' => 'internal'), $this->command->getDefinition());
        $output = new BufferedOutput();

        $this->command->run($input, $output);

        $result = $output->fetch();

        $this->assertEquals(11, strlen($result)); // 10 + 1 for the new line
    }
}