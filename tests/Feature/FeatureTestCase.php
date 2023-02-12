<?php

declare(strict_types=1);

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class FeatureTestCase extends WebTestCase
{
    protected function getApiClient(): HttpClientInterface
    {
        $baseUrl = $_ENV['API_BASE_URL'] ?? null;
        if (!$baseUrl) {
            throw new \RuntimeException('Missing "API_BASE_URL" environment variable');
        }

        return HttpClient::create([
            'base_uri' => $baseUrl,
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);
    }
}