<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Config;

use Magento\MagentoCloud\Config\EnvironmentDataInterface;

class WebhookData
{
    /**
     * @var EnvironmentDataInterface
     */
    protected EnvironmentDataInterface $environmentData;

    /**
     * @param EnvironmentDataInterface $environmentData
     */
    public function __construct(
        EnvironmentDataInterface $environmentData
    ) {
        $this->environmentData = $environmentData;
    }

    /**
     * @return string
     */
    public function getTeamsWebhookUrl(): string
    {
        return $this->environmentData->getVariables()['TEAMS_WEBHOOK_URL'] ?? '';
    }

    /**
     * @return string
     */
    public function getBranchName(): string
    {
        return $this->environmentData->getBranchName();
    }
}
