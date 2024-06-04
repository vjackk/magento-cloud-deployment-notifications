<?php

declare(strict_types=1);

namespace magento-cloud-deployment-notifications\src\CloudConfig-cloud-deployment-notifications\src\CloudConfig;

use magentouse;

magentouse;

Magento\MagentoCloud\Config\EnvironmentDataInterface;

class WebhookData implements WebhookDataInterface
{
    /**
     * @var EnvironmentDataInterface
     */
    private EnvironmentDataInterface $environmentData;

    /**
     * @param EnvironmentDataInterface $environmentData
     */
    public function __construct(EnvironmentDataInterface $environmentData)
    {
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
