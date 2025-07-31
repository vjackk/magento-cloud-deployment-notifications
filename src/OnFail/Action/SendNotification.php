<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\OnFail\Action;

use Magento\MagentoCloud\OnFail\Action\ActionException;
use Magento\MagentoCloud\OnFail\Action\ActionInterface;
use Vjackk\DeploymentNotifications\Config\WebhookData;
use Vjackk\DeploymentNotifications\Service\Teams;
use Vjackk\DeploymentNotifications\Tools\Util;

class SendNotification implements ActionInterface
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
     * @var Teams
     */
    protected Teams $teamsService;

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
     * @param Teams $teamsService
     * @param string $stepCode
     * @param array $messageWrapper
     */
    public function __construct(
        Util $util,
        WebhookData $webhookData,
        Teams $teamsService,
        string $stepCode = '',
        array $messageWrapper = []
    ) {
        $this->util = $util;
        $this->webhookData = $webhookData;
        $this->teamsService = $teamsService;
        $this->stepCode = $stepCode;
        $this->messageWrapper = $messageWrapper;
    }

    public function execute(): void
    {
        try {
            $webhookUrl = $this->webhookData->getTeamsWebhookUrl();
            if (!$webhookUrl) {
                return;
            }

            $message = call_user_func_array(
                'sprintf',
                $this->util->formatMessageWrapper($this->messageWrapper)
            );
            
            if (!$this->teamsService->doRequest($webhookUrl, $message, $this->stepCode)) {
                throw new ActionException('Something went wrong with Teams webhook url');
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
