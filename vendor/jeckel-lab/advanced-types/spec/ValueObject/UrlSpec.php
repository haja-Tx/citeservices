<?php

namespace spec\JeckelLab\AdvancedTypes\ValueObject;

use Faker\Factory;
use JeckelLab\AdvancedTypes\ValueObject\Url;
use PhpSpec\ObjectBehavior;

class UrlSpec extends ObjectBehavior
{
    private $faker;
    private $url;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->url = $this->faker->url;
    }

    function it_is_initializable()
    {
        $this->beConstructedWith($this->url);
        $this->shouldHaveType(Url::class);
    }

    function it_should_return_the_url()
    {
        $this->beConstructedWith($this->url);
        $this->getUrl()->shouldReturn($this->url);
    }

    function it_validate_equality()
    {
        $url = new Url($this->url);
        $this->beConstructedWith($this->url);
        $this->equals($url)->shouldReturn(true);
    }

    function it_reject_inequality()
    {
        $url = new Url($this->url . '/foo');
        $this->beConstructedWith($this->url);
        $this->equals($url)->shouldReturn(false);
    }

    function it_return_url_as_string()
    {
        $this->beConstructedWith($this->url);
        $this->__toString()->shouldReturn($this->url);
    }
}
