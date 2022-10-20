<?php

namespace spec\JeckelLab\AdvancedTypes\ValueObject;

use JeckelLab\AdvancedTypes\ValueObject\TimeDuration;
use PhpSpec\ObjectBehavior;

class TimeDurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith(123);
        $this->shouldHaveType(TimeDuration::class);
    }

    function it_return_duration_as_int()
    {
        $this->beConstructedWith(123);
        $this->getValue()->shouldReturn(123);
    }

    function it_add_int_to_duration()
    {
        $this->beConstructedWith(123);
        $this->add(245)->shouldBeAnInstanceOf(TimeDuration::class);
        $this->add(245)->getValue()->shouldBe(368);
        $this->getValue()->shouldBe(123);
    }

    function it_sub_int_to_duration()
    {
        $this->beConstructedWith(123);
        $this->sub(23)->shouldBeAnInstanceOf(TimeDuration::class);
        $this->sub(23)->getValue()->shouldBe(100);
        $this->getValue()->shouldBe(123);
    }

    function it_add_duration_to_duration()
    {
        $duration = new TimeDuration(245);
        $this->beConstructedWith(123);
        $this->add($duration)->shouldBeAnInstanceOf(TimeDuration::class);
        $this->add($duration)->getValue()->shouldBe(368);
        $this->getValue()->shouldBe(123);
    }

    function it_sub_duration_to_duration()
    {
        $duration = new TimeDuration(23);
        $this->beConstructedWith(123);
        $this->sub($duration)->shouldBeAnInstanceOf(TimeDuration::class);
        $this->sub($duration)->getValue()->shouldBe(100);
        $this->getValue()->shouldBe(123);
    }

    function it_return_format_for_seconds()
    {
        $this->beConstructedWith(12);
        $this->format()->shouldBe('12');
    }

    function it_return_format_for_minute()
    {
        $this->beConstructedWith(112);
        $this->format()->shouldBe('1:52');
    }

    function it_return_format_for_minutes()
    {
        $this->beConstructedWith(1120);
        $this->format()->shouldBe('18:40');
    }

    function it_return_format_for_hours()
    {
        $this->beConstructedWith(7000);
        $this->format()->shouldBe('1:56:40');
    }

    function it_return_format_as_string()
    {
        $this->beConstructedWith(7000);
        $this->__toString()->shouldBe('1:56:40');
    }

    function it_validate_equality()
    {
        $duration = new TimeDuration(123);
        $this->beConstructedWith(123);
        $this->equals($duration)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $duration = new TimeDuration(12);
        $this->beConstructedWith('123');
        $this->equals($duration)->shouldReturn(false);
    }
}
