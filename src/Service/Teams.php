<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Vjackk\DeploymentNotifications\App\Logger;

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
     * @param Client $logger
     */
    public function __construct(
        LoggerInterface $logger,
        Client $client
    ) {
        $this->logger = $logger;
        $this->client = $client;
    }

    /**
     * Send notification.
     * @return bool
     */
    public function doRequest($webhookUrl, $successMessage)
    {
        $payload = [
            'text' => $successMessage
        ];
        try {
            $response = $this->client->post($webhookUrl, [
                'json' => $payload
            ]);
            if ($response->getStatusCode() == 200) {
                $this->logger->info('Test');
            }
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
            return false;
        }
    }
}
