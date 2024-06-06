<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\OnFail\Action;

use Magento\MagentoCloud\OnFail\Action\ActionException;
use Magento\MagentoCloud\OnFail\Action\ActionInterface;
use Magento\MagentoCloud\Step\StepException;
use Throwable;
use Vjackk\DeploymentNotifications\Config\WebhookData;
use Vjackk\DeploymentNotifications\Service\Teams;

class SendFailedNotification implements ActionInterface
{
    /**
     * @var WebhookData
     */
    protected WebhookData $webhookData;

    /**
     * @var Teams
     */
    protected Teams $teamsService;

    /**
     * @param WebhookData $webhookData
     * @param Teams $teamsService
     */
    public function __construct(
        WebhookData $webhookData,
        Teams $teamsService
    ) {
        $this->webhookData = $webhookData;
        $this->teamsService = $teamsService;
    }

    public function execute(): void
    {
        try {
            $webhookUrl = $this->webhookData->getTeamsWebhookUrl();
            $branchName = $this->webhookData->getBranchName();
            if (!$webhookUrl) {
                return;
            }

            $message = str_replace('%1', $branchName, 'Deployment of %1 has failed. Check logs for details.');
            if (!$this->teamsService->doRequest($webhookUrl, $message)) {
                throw new StepException('Something went wrong with Teams webhook url');
            }
        } catch (Throwable $exception) {
            throw new ActionException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        }
    }
}
