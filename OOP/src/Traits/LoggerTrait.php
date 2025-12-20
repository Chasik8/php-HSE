<?php

declare(strict_types=1);

namespace App\Traits;

trait LoggerTrait
{
    public function log(string $message): void
    {
        echo sprintf("[%s] LOG: %s" . PHP_EOL, date('Y-m-d H:i:s'), $message);
    }
}
