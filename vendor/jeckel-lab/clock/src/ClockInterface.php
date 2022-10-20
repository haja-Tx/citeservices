<?php
declare(strict_types=1);

namespace JeckelLab\Clock;

use DateTimeImmutable;

/**
 * Interface ClockInterface
 */
interface ClockInterface
{
    /**
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable;
}
