<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Config;

interface WebhookDataInterface
{
    /**
     * Returns webhook url.
     *
     * @return string
     */
    public function getTeamsWebhookUrl(): string;
}
