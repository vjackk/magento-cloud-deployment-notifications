<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Config;

use Magento\MagentoCloud\Config\EnvironmentDataInterface;

class WebhookData
{
    /**
     * @var EnvironmentDataInterface
     */
    protected $environmentData;

    /**
     * @param EnvironmentDataInterface $environmentData
     */
    public function __construct(
        EnvironmentDataInterface $environmentData
    ) {
        $this->environmentData = $environmentData;
    }

    /**
     * @inheritDoc
     */
    public function getTeamsWebhookUrl(): string
    {
        return $this->environmentData->getVariables()['TEAMS_WEBHOOK_URL'] ?? '';
    }
}
