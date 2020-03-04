<?php

declare(strict_types=1);

namespace App\Test\Service;

use App\Service\VidexComesConnectedScraperService;
use PHPUnit\Framework\TestCase;

class VidexComesConnectedScraperServiceTest extends TestCase
{
    private const SELECTORS = [
        'option title',
        'description',
        'price',
        'discount',
    ];

    /** @var VidexComesConnectedScraperService */
    private $videxComesConnectedScraperService;

    public function setup(): void
    {
        $this->videxComesConnectedScraperService = new VidexComesConnectedScraperService();
    }

    public function testValidUrlWithoutDimensions(): void
    {
        $dataJson = $this->videxComesConnectedScraperService->execute();
        $data = json_decode($dataJson, true);

        $this->assertCount(6, $data, 'Count is not correct');
        $this->assertArrayHasKey(static::SELECTORS[0], $data[0]);
        $this->assertArrayHasKey(static::SELECTORS[1], $data[0]);
        $this->assertArrayHasKey(static::SELECTORS[2], $data[0]);
        $this->assertArrayHasKey(static::SELECTORS[3], $data[1]);
    }
}
