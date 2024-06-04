<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Step\PostDeploy;

use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;
use Vjackk\DeploymentNotifications\Config\WebhookDataInterface;
use Vjackk\DeploymentNotifications\Service\Teams as TeamsService;

/**
 * Send notification after deployment
 */
class SendNotification implements StepInterface
{
    /**
     * @var WebhookDataInterface
     */
    protected WebhookDataInterface $webhookData;

    /**
     * @var TeamsService
     */
    protected TeamsService $teamsService;

    /**
     * @param WebhookDataInterface $webhookData
     * @param TeamsService $teamsService
     */
    public function __construct(
        WebhookDataInterface $webhookData,
        TeamsService $teamsService
    ) {
        $this->webhookData = $webhookData;
        $this->teamsService = $teamsService;
    }

    /**
     * Send notification.
     * @return void
     * @throws StepException
     */
    public function execute()
    {
        $this->sendTeamsNotification();
    }

    /**
     * Send Teams notification.
     * @return void
     * @throws StepException
     */
    private function sendTeamsNotification()
    {
        $webhookUrl = $this->webhookData->getTeamsWebhookUrl();
        if (!$webhookUrl) {
            return;
        }

        $successMessage = 'Deployment has been finished with success';
        if (!$this->teamsService->doRequest($webhookUrl, $successMessage)) {
            throw new StepException('Something went wrong with Teams webhook url');
        }
    }
}
