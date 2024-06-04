<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\App;

use Vjackk\DeploymentNotifications\App\Logger\LineFormatterFactory;
use Vjackk\DeploymentNotifications\Filesystem\FileList;
use Vjackk\DeploymentNotifications\Filesystem\Filesystem;
use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;

/**
 * @inheritdoc
 */
class Logger extends \Monolog\Logger
{
    /**
     * @param FileList $fileList
     * @param Logger\LineFormatterFactory $lineFormatterFactory
     * @param Filesystem $filesystem
     */
    public function __construct(
        FileList $fileList,
        LineFormatterFactory $lineFormatterFactory,
        Filesystem $filesystem
    ) {
        $handlers = [];
        $logPath = $fileList->getDeploymentNotificationLog();
        $logDir = $filesystem->getDirectory($logPath);
        $filesystem->createDirectory($logDir);

        if ($filesystem->isWritable($logDir)) {
            try {
                $handlerInstance = new StreamHandler($logPath, Logger::DEBUG);
                $formatter = $lineFormatterFactory->create();
                $handlerInstance->setFormatter($formatter);
                $handlers[] = $handlerInstance;
            } catch (\Exception $e) {
                $handlers[] = new NullHandler();
            }
        } else {
            $handlers[] = new NullHandler();
        }

        parent::__construct('default', $handlers);
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = []): void
    {
        $message = strip_tags($message);

        parent::info($message, $context);
    }
}
