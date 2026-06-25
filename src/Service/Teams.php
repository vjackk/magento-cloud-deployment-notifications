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
     * Sends a Teams notification via Power Automate webhook using Adaptive Cards format.
     *
     * @param string $webhookUrl
     * @param string $message
     * @param string $step
     * @return bool
     */
    public function doRequest(string $webhookUrl, string $message, $step): bool
    {
        $payload = [
            'type' => 'message',
            'attachments' => [
                [
                    'contentType' => 'application/vnd.microsoft.card.adaptive',
                    'content' => [
                        '$schema' => 'http://adaptivecards.io/schemas/adaptive-card.json',
                        'type' => 'AdaptiveCard',
                        'version' => '1.2',
                        'body' => [
                            [
                                'type' => 'TextBlock',
                                'text' => $message,
                                'wrap' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ];
        try {
            $response = $this->client->post($webhookUrl, [
                'json' => $payload
            ]);
            if ($response->getStatusCode() == 202) {
                $this->logger->info(sprintf('%s : Teams notification sent', $step));
                return true;
            }
        } catch (GuzzleException $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }
}
