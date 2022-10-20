<?php

namespace spec\JeckelLab\AdvancedTypes\ValueObject;

use Faker\Factory;
use JeckelLab\AdvancedTypes\ValueObject\Email;
use PhpSpec\ObjectBehavior;

class EmailSpec extends ObjectBehavior
{
    private $faker;
    private $email;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->email = $this->faker->email;
    }

    function it_is_initializable()
    {
        $this->beConstructedWith($this->email);
        $this->shouldHaveType(Email::class);
    }

    function it_should_return_the_email()
    {
        $this->beConstructedWith($this->email);
        $this->getEmail()->shouldReturn($this->email);
    }

    function it_validate_equality()
    {
        $email = new Email($this->email);
        $this->beConstructedWith($this->email);
        $this->equals($email)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $email = new Email('foo.' . $this->email);
        $this->beConstructedWith($this->email);
        $this->equals($email)->shouldReturn(false);
    }

    function it_return_email_as_string()
    {
        $this->beConstructedWith($this->email);
        $this->__toString()->shouldReturn($this->email);
    }
}
