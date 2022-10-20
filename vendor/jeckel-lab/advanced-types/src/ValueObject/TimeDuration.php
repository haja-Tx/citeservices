<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use JeckelLab\AdvancedTypes\ValueObject\Exception\InvalidArgumentException;
use Assert\Assert;
use RuntimeException;

/**
 * Class TimeDuration
 * @psalm-immutable
 */
class TimeDuration implements ValueObject, Equality
{
    /**
     * @var int
     */
    protected $duration;

    /**
     * TimeDuration constructor.
     * @param int $duration
     */
    public function __construct(int $duration = 0)
    {
        Assert::that($duration)->greaterOrEqualThan(0);
        $this->duration = $duration;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->duration;
    }

    /**
     * @param string|null $format
     * @return string
     * @throws RuntimeException
     */
    public function format(?string $format = null): string
    {
        if (null === $format) {
            $format = $this->getOptimalFormat();
        }
        $pattern = ['/%h/', '/%m/', '/%s/', '/%M/', '/%S/'];
        $hours = floor($this->duration / 3600);
        $minutes = floor(($this->duration % 3600) / 60);
        $seconds = $this->duration % 60;

        $values  = [
            (string) $hours,
            (string) $minutes,
            (string) $seconds,
            sprintf('%02d', $minutes),
            sprintf('%02d', $seconds)
        ];

        $result = preg_replace($pattern, $values, $format);
        if (is_string($result)) {
            return $result;
        }
        throw new RuntimeException('Invalid format for time duration ' . $format);
    }

    /**
     * @return string
     */
    protected function getOptimalFormat(): string
    {
        if ($this->duration > 3600) {
            return '%h:%M:%S';
        }
        if ($this->duration > 60) {
            return '%m:%S';
        }
        return '%s';
    }

    /**
     * @param int|TimeDuration $duration
     * @return self
     */
    public function add($duration): self
    {
        if ($duration instanceof self) {
            $duration = $duration->duration;
        }
        if (! is_int($duration)) {
            throw new InvalidArgumentException('Invalid argument, int or TimeDuration expected');
        }
        return new self($duration + $this->duration);
    }

    /**
     * @param int|TimeDuration $duration
     * @return self
     */
    public function sub($duration): self
    {
        if ($duration instanceof self) {
            $duration = $duration->duration;
        }
        if (! is_int($duration)) {
            throw new InvalidArgumentException('Invalid argument, int or TimeDuration expected');
        }
        return new self($this->duration - $duration);
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return $object->duration === $this->duration;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
