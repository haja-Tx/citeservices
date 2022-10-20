<?php

/**
 * @author: Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 04/06/2020
 */

declare(strict_types=1);

namespace Tests\JeckelLab\AdvancedTypes\ValueObject;

use Assert\InvalidArgumentException;
use JeckelLab\AdvancedTypes\ValueObject\TimeDuration;
use PHPUnit\Framework\TestCase;

/**
 * Class TimeDurationTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject
 */
class TimeDurationTest extends TestCase
{
    public function testInvalidDuration(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new TimeDuration(-1);
    }

    public function testEmptyDuration(): void
    {
        $this->assertEquals(0, (new TimeDuration(0))->getValue());
        $this->assertEquals(0, (new TimeDuration())->getValue());
    }

    public function testAdd(): void
    {
        $duration = new TimeDuration(200);
        $newDuration = $duration->add(50);
        $this->assertNotSame($duration, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(250, $newDuration->getValue());
    }

    public function testSub(): void
    {
        $duration = new TimeDuration(200);
        $newDuration = $duration->sub(50);
        $this->assertNotSame($duration, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(150, $newDuration->getValue());
    }

    public function testSubDuration(): void
    {
        $duration = new TimeDuration(200);
        $diff = new TimeDuration(50);
        $newDuration = $duration->sub($diff);
        $this->assertNotSame($duration, $newDuration);
        $this->assertNotSame($diff, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(50, $diff->getValue());
        $this->assertEquals(150, $newDuration->getValue());
    }

    public function testAddDuration(): void
    {
        $duration = new TimeDuration(200);
        $diff = new TimeDuration(50);
        $newDuration = $duration->add($diff);
        $this->assertNotSame($duration, $newDuration);
        $this->assertNotSame($diff, $newDuration);
        $this->assertEquals(200, $duration->getValue());
        $this->assertEquals(50, $diff->getValue());
        $this->assertEquals(250, $newDuration->getValue());
    }
}
