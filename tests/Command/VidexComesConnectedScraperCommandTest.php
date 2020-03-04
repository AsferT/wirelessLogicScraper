<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class VidexComesConnectedScraperCommandTest extends KernelTestCase
{
    public function testOptionNamesExist(): void
    {
        $output = $this->executeCommand([]);
        $this->assertContains('Option 40 Mins', $output);
        $this->assertContains('Option 160 Mins', $output);
        $this->assertContains('Option 300 Mins', $output);
        $this->assertContains('Option 480 Mins', $output);
        $this->assertContains('Option 2000 Mins', $output);
        $this->assertContains('Option 3600 Mins', $output);
    }

    /**
     * @param array $arguments
     * @param array $inputs
     * @return string
     */
    private function executeCommand(array $arguments, array $inputs = []): string
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);
        $command = $application->find('videx:scraper');

        $commandTester = new CommandTester($command);
        $commandTester->setInputs($inputs);
        $commandTester->execute($arguments);

        return $commandTester->getDisplay();
    }
}
