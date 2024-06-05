<?php

declare(strict_types=1);

namespace Vjackk\DeploymentNotifications\App;

use Exception;
use Throwable;

/**
 * Base exception class.
 */
class GenericException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message, int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
