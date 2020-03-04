<?php

declare(strict_types=1);

namespace App\Service;

use Goutte\Client;

class VidexComesConnectedScraperService
{
    public const SELECTORS = [
        'option title' => 'h3',
        'description' => '.package-name',
        'price' => '.price-big',
        'discount' => '.package-price p',
    ];

    public function execute()
    {
        $client = new Client();
        $docCrawler = $client->request('GET', 'https://videx.comesconnected.com/');
        $totalPackages = $docCrawler->filter(static::SELECTORS['option title'])->count();
        $data = [];

        for ($counter = 0; $counter < $totalPackages; ++$counter) {
            $packageDocCrawler = $docCrawler->filter('.package')->eq($counter);
            foreach (static::SELECTORS as $key => $selector) {
                $filterResults = $packageDocCrawler->filter($selector);
                if ($filterResults->count() > 0) {
                    foreach ($filterResults as $filterResult) {
                        $data[$counter][$key] = $filterResult->nodeValue;
                    }
                }
            }
        }

        $data = $this->parseData($data);

        return json_encode($data);
    }

    private function parseData(array $data): array
    {
        foreach ($data as $key => $packageDetails) {
            $data[$key]['price'] = str_replace('£', '', $data[$key]['price']);
            if (isset($packageDetails['description'])) {
                if (false !== strpos($packageDetails['description'], 'month')) {
                    $data[$key]['price'] = '£' . number_format((float)$data[$key]['price'] * 12, 2);
                } else {
                    $data[$key]['price'] = '£' . number_format((float)$data[$key]['price'], 2);
                }
            }
        }

        usort($data, static function ($a, $b) {
            return $b['price'] <=> $a['price'];
        });

        return $data;
    }
}
