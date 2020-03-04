<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\VidexComesConnectedScraperService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VidexComesConnectedScraperCommand extends Command
{
    protected static $defaultName = 'videx:scraper';

    /** @var VidexComesConnectedScraperService */
    private $videxComesConnectedScraperService;

    public function __construct(VidexComesConnectedScraperService $videxComesConnectedScraperService)
    {
        $this->videxComesConnectedScraperService = $videxComesConnectedScraperService;
        parent::__construct();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($this->videxComesConnectedScraperService->execute());

        return 0;
    }
}
