<?php

namespace Sampler\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sampler\Sampler\AbstractSampler;
use Sampler\Input\RandomByteIterator;
use Sampler\Input\RandomOrgIterator;
use Sampler\Input\StreamIterator;
use Buzz\Client\ClientInterface;

class SampleCommand extends Command
{
    protected $sampler;
    protected $httpClient;

    /**
     * @param string $name
     * @param AbstractSampler $sampler
     * @param ClientInterface $httpClient
     */
    public function __construct($name, AbstractSampler $sampler, ClientInterface $httpClient)
    {
        $this->sampler = $sampler;
        $this->httpClient = $httpClient;

        parent::__construct($name);
    }

    protected function configure()
    {
        $this->addOption('input', 'i', InputOption::VALUE_OPTIONAL, 'Input source (stdin, random.org, internal)', 'stdin');
        $this->addOption('size', 's', InputOption::VALUE_OPTIONAL, 'Sample size (1 - 2000)', 5);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputSource = $input->getOption('input');
        $size = (int)$input->getOption('size');

        if ($size < 1 || $size > 2000) {
            $output->writeln('<error>Sample size must be a positive integer between 1 and 2000.</error>');
            return;
        }

        // Input size should be 10 times the size of the sample
        $streamSize = $size * 10;

        switch ($inputSource) {
            case 'stdin':
                $stream = new StreamIterator;
                break;
            case 'random.org':
                $stream = new RandomOrgIterator($this->httpClient);
                $stream->setLength($streamSize);
                break;
            case 'internal':
                $stream = new RandomByteIterator();
                $stream->setLength($streamSize);
                break;
            default:
                $output->writeln('<error>Unknown input source: "' . $inputSource . '". Use either stdin, random.org or internal.</error>');
                return;
        }

        $this->sampler->setStream($stream);

        $result = $this->sampler->getSampleAsString($size);

        $output->writeln($result);
    }
}