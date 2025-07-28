<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Step\Deploy;

use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;
use Vjackk\DeploymentNotifications\Config\WebhookData;
use Vjackk\DeploymentNotifications\Service\Teams as TeamsService;

/**
 * Send notification after deployment
 */
class SendNotification implements StepInterface
{
    /**
     * @var WebhookData
     */
    protected WebhookData $webhookData;

    /**
     * @var TeamsService
     */
    protected TeamsService $teamsService;

    /**
     * @param WebhookData $webhookData
     * @param TeamsService $teamsService
     */
    public function __construct(
        WebhookData $webhookData,
        TeamsService $teamsService
    ) {
        $this->webhookData = $webhookData;
        $this->teamsService = $teamsService;
    }

    /**
     * Send Teams notification.
     * @return void
     * @throws StepException
     */
    public function execute(): void
    {
        $this->sendTeamsNotification();
    }

    /**
     * Send Teams notification.
     * @return void
     * @throws StepException
     */
    private function sendTeamsNotification(): void
    {
        $webhookUrl = $this->webhookData->getTeamsWebhookUrl();
        $branchName = $this->webhookData->getBranchName();
        if (!$webhookUrl) {
            return;
        }

        $message = sprintf('Deployment of %s has finished with success', $branchName);
        if (!$this->teamsService->doRequest($webhookUrl, $message, 'DEPLOY_START')) {
            throw new StepException('Something went wrong with Teams webhook url');
        }
    }
}
