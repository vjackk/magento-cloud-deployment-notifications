<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Model\Variable;

interface VariableInterface
{
    public function execute(): string;
}
