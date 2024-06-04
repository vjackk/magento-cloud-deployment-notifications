<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\App;

/**
 * Interface for DI container
 */
interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * Create an object
     *
     * @param string $abstract
     * @param array $params
     * @return mixed
     */
    public function create(string $abstract, array $params = []);
}
