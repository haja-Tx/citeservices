<?php
declare(strict_types=1);

namespace Tests\JeckelLab\Clock;

use JeckelLab\Clock\FakeClock;
use PHPUnit\Framework\TestCase;

/**
 * Class FakeClockTest
 * @package Test\Jeckel\Clock
 */
final class FakeClockTest extends TestCase
{
    /**
     * @test now
     */
    public function testNow()
    {
        $time = new \DateTimeImmutable('2018-01-01 12:00:00');
        $clock = new FakeClock($time);
        $this->assertSame($time, $clock->now());
    }

    /**
     * @test setTo
     */
    public function testSetTo()
    {
        $time = new \DateTimeImmutable('2018-01-01 12:00:00');
        $clock = new FakeClock(new \DateTimeImmutable('2016-01-01 12:30:00'));
        $clock->setClock($time);
        $this->assertSame($time, $clock->now());
    }
}
