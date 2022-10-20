<?php
declare(strict_types=1);

namespace JeckelLab\Clock;

use DateTimeImmutable;

/**
 * Class FakeClock
 * @package Jeckel\Clock
 */
class FakeClock implements ClockInterface
{
    /**
     * @var DateTimeImmutable
     */
    protected $now;

    /**
     * FakeClock constructor.
     * @param DateTimeImmutable $now
     */
    public function __construct(DateTimeImmutable $now)
    {
        $this->now = $now;
    }

    /**
     * @param DateTimeImmutable $now
     */
    public function setClock(DateTimeImmutable $now): void
    {
        $this->now = $now;
    }

    /**
     * @return DateTimeImmutable
     */
    public function now(): DateTimeImmutable
    {
        return $this->now;
    }
}
