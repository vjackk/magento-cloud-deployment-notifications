<?php

declare(strict_types=1);

namespace magento-cloud-deployment-notifications\src\CloudConfig-cloud-deployment-notifications\src\CloudConfig;

interface WebhookDataInterface
{
    /**
     * Returns webhook url.
     *
     * @return string
     */
    public function getTeamsWebhookUrl(): string;
}
