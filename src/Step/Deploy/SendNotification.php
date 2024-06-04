<?php

declare(strict_types=1);

namespace magento-cloud-deployment-notifications\src\Step\Deploy-cloud-deployment-notifications\src\Step\Deploy;

use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;
use notifications\src\CloudConfig\WebhookDataInterface;
use notifications\src\Service\Teams as TeamsService;

/**
 * Send notification after deployment
 */
class SendNotification implements StepInterface
{
    /**
     * @var notifications\src\CloudConfig\notifications\src\CloudConfig\WebhookDataInterface
     */
    protected WebhookDataInterface $webhookData;

    /**
     * @var TeamsService
     */
    protected TeamsService $teamsService;

    /**
     * @param notifications\src\CloudConfig\notifications\src\CloudConfig\WebhookDataInterface $webhookData
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
        if (!$webhookUrl) {
            return;
        }

        $successMessage = 'Deployment has been finished with success';
        if (!$this->teamsService->doRequest($webhookUrl, $successMessage)) {
            throw new StepException('Something went wrong with Teams webhook url');
        }
    }
}
