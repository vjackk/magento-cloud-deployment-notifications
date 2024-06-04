<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Step\Deploy;

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
     * Send Teams notification.
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
        $webhookUrl = 'https://verisure.webhook.office.com/webhookb2/d381364d-30be-4f4b-827c-400e989095db@3055fa7f-a944-4927-801e-a62b63119e43/IncomingWebhook/64d4d3734bcb4d83b35539c3404cef6c/cb0313ed-2de6-47c4-9d9a-ded70d00f888';
        echo $webhookUrl;
        if (!$webhookUrl) {
            return;
        }

        $successMessage = 'Deployment has been finished with success';
        if (!$this->teamsService->doRequest($webhookUrl, $successMessage)) {
            throw new StepException('Something went wrong with Teams webhook url');
        }
    }
}
