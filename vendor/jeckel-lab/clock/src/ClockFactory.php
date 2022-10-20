<?php
declare(strict_types=1);

namespace JeckelLab\Clock;

use DateTimeImmutable;
use Exception;

/**
 * Class ClockFactory
 * @package Jeckel\Clock
 */
class ClockFactory
{
    /**
     * @param bool   $fakeClock
     * @param string $fakeClockFile
     * @return ClockInterface
     * @throws Exception
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    public static function getClock(bool $fakeClock = false, string $fakeClockFile = ''): ClockInterface
    {
        if ($fakeClock) {
            if (is_readable($fakeClockFile)) {
                $clock = file_get_contents($fakeClockFile);
            }
            if (empty($clock)) {
                $clock = 'now';
            }

            return new FakeClock(new DateTimeImmutable($clock));
        }
        return new Clock();
    }
}
