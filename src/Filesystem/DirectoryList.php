<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Filesystem;

/**
 * List of app directories.
 */
class DirectoryList
{
    /**
     * @var string
     */
    private string $root;

    /**
     * @var string
     */
    private string $magentoRoot;

    /**
     * @param string $root
     * @param string $magentoRoot
     */
    public function __construct(
        string $root,
        string $magentoRoot
    ) {
        $this->root = realpath($root);
        $this->magentoRoot = realpath($magentoRoot);
    }

    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->root;
    }

    /**
     * @return string
     */
    public function getMagentoRoot(): string
    {
        return $this->magentoRoot;
    }
}
