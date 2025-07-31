<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Model\Variable;

use Vjackk\DeploymentNotifications\Config\WebhookData;
use Vjackk\DeploymentNotifications\Service\Teams;

class GetBranchName implements VariableInterface
{
    /**
     * @var WebhookData
     */
    protected WebhookData $webhookData;

    /**
     * @param WebhookData $webhookData
     */
    public function __construct(
        WebhookData $webhookData,
    ) {
        $this->webhookData = $webhookData;
    }

    public function execute(): string
    {
        return $this->webhookData->getBranchName();
    }
}
