<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\Tools;

use Vjackk\DeploymentNotifications\Model\Variable\VariableInterface;

/**
 * Tool class
 */
class Util
{
    /**
     * @param array $messageWrapper
     * @return array
     */
    public function formatMessageWrapper(array $messageWrapper): array
    {
        $result = [];
        foreach ($messageWrapper as $key => $message) {
            if ($message instanceof VariableInterface) {
                $result[] = $message->execute();
            } else {
                $result[] = $message;
            }
        }
        return $result;
    }
}
