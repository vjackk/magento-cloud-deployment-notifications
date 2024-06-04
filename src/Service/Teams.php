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
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * Send notification.
     * @return bool
     */
    public function doRequest($webhookUrl, $successMessage)
    {
        $client = new Client();
        $payload = [
            'text' => $successMessage
        ];
        try {
            $response = $client->post($webhookUrl, [
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
