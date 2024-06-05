<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

/**
 * Teams service
 */
class Teams
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param LoggerInterface $logger
     * @param Client $client
     */
    public function __construct(
        LoggerInterface $logger,
        Client $client
    ) {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * @param string $webhookUrl
     * @param string $successMessage
     * @return bool
     */
    public function doRequest(string $webhookUrl, string $successMessage): bool
    {
        $payload = [
            'text' => $successMessage
        ];
        try {
            $response = $this->client->post($webhookUrl, [
                'json' => $payload
            ]);
            if ($response->getStatusCode() == 200) {
                $this->logger->info('Teams notification sent');
                return true;
            }
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }
}
