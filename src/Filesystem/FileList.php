<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Filesystem;

/**
 * List of app files.
 */
class FileList
{
    /**
     * @var DirectoryList
     */
    private $directoryList;

    /**
     * @param DirectoryList $directoryList
     */
    public function __construct(DirectoryList $directoryList)
    {
        $this->directoryList = $directoryList;
    }

    /**
     * @return string
     */
    public function getDeploymentNotificationLog(): string
    {
        return $this->directoryList->getMagentoRoot() . '/var/log/deployment-notification.log';
    }

    /**
     * @return string
     */
    public function getEnvConfig(): string
    {
        return $this->directoryList->getMagentoRoot() . '/.magento.env.yaml';
    }
}
