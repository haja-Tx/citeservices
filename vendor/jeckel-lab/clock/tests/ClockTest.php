<?php
declare(strict_types=1);

namespace Tests\JeckelLab\Clock;

use DateTimeImmutable;
use Exception;
use JeckelLab\Clock\Clock;
use PHPUnit\Framework\TestCase;

final class ClockTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testNow()
    {
        $now = new DateTimeImmutable('now');
        $clock = new Clock();
        $time = $clock->now();
        $this->assertGreaterThanOrEqual($now, $time);
        $this->assertLessThanOrEqual(new DateTimeImmutable('now'), $time);

        // 2nd call return a new DateTimeImmutable
        $this->assertNotSame($time, $clock->now());
    }
}
