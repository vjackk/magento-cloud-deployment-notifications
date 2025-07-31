<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Step;

use Magento\MagentoCloud\Step\StepException;
use Magento\MagentoCloud\Step\StepInterface;
use Vjackk\DeploymentNotifications\Config\WebhookData;
use Vjackk\DeploymentNotifications\Service\Teams as TeamsService;
use Vjackk\DeploymentNotifications\Tools\Util;

/**
 * Send notification after deployment
 */
class SendNotification implements StepInterface
{
    /**
     * @var Util
     */
    protected Util $util;
    
    /**
     * @var WebhookData
     */
    protected WebhookData $webhookData;

    /**
     * @var TeamsService
     */
    protected TeamsService $teamsService;

    /**
     * @var string
     */
    protected string $stepCode;

    /**
     * @var array
     */
    protected array $messageWrapper;

    /**
     * @param Util $util
     * @param WebhookData $webhookData
     * @param TeamsService $teamsService
     */
    public function __construct(
        Util $util,
        WebhookData $webhookData,
        TeamsService $teamsService,
        string $stepCode = '',
        array $messageWrapper = [],
    ) {
        $this->util = $util;
        $this->webhookData = $webhookData;
        $this->teamsService = $teamsService;
        $this->stepCode = $stepCode;
        $this->messageWrapper = $messageWrapper;
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
        if (!$webhookUrl) {
            return;
        }

        $message = call_user_func_array(
            'sprintf',
            $this->util->formatMessageWrapper($this->messageWrapper)
        );
        if (!$this->teamsService->doRequest($webhookUrl, $message, $this->stepCode)) {
            throw new StepException('Something went wrong with Teams webhook url');
        }
    }
}
