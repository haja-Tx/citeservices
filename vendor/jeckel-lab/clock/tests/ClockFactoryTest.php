<?php
declare(strict_types=1);

namespace Tests\JeckelLab\Clock;

use DateTimeImmutable;
use Exception;
use JeckelLab\Clock\Clock;
use JeckelLab\Clock\ClockFactory;
use JeckelLab\Clock\FakeClock;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamWrapper;
use PHPUnit\Framework\TestCase;

/**
 * Class ClockFactoryTest
 * @package Test\Jeckel\Clock
 */
final class ClockFactoryTest extends TestCase
{
    /**
     * @test getClock
     */
    public function testGetClock()
    {
        $this->assertInstanceOf(Clock::class, ClockFactory::getClock());
    }

    /**
     * @test getClock
     * @throws Exception
     */
    public function testGetFakeClock()
    {
        $now = new DateTimeImmutable('now');

        $clock = ClockFactory::getClock(true);
        $this->assertInstanceOf(FakeClock::class, $clock);

        $time = $clock->now();

        $this->assertGreaterThanOrEqual($now, $time);
        $this->assertLessThanOrEqual(new DateTimeImmutable('now'), $time);
    }

    /**
     * @test getClock
     * @throws Exception
     */
    public function testGetFakeClockFromFile()
    {
        $frozentime = "2018-02-01 10:30:15";
        $root = vfsStream::setup('root', 444, ['clock' => $frozentime]);
        $clock = ClockFactory::getClock(true, $root->url() . '/clock');
        $this->assertEquals($frozentime, $clock->now()->format('Y-m-d h:i:s'));
    }
}
