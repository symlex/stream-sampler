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
        $this->addOption('size', 's', InputOption::VALUE_OPTIONAL, 'Sample size', 5);

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputSource = $input->getOption('input');
        $size = (int)$input->getOption('size');

        switch ($inputSource) {
            case 'stdin':
                $stream = new StreamIterator;
                break;
            case 'random.org':
                $stream = new RandomOrgIterator($size, $this->httpClient);
                break;
            case 'internal':
                $stream = new RandomByteIterator($size);
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