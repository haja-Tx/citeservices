<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\DBAL\Types;

use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use JeckelLab\AdvancedTypes\DBAL\Types\UrlType;
use JeckelLab\AdvancedTypes\ValueObject\Url;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class UrlTypeTest
 * @package Tests\JeckelLab\AdvancedTypes\DBAL\Types
 */
class UrlTypeTest extends TestCase
{
    /**
     * @var AbstractPlatform|MockObject
     */
    protected $platform;

    protected function setUp(): void
    {
        parent::setUp();
        $this->platform = $this->getMockForAbstractClass(AbstractPlatform::class);
    }

    /**
     * @dataProvider getDbValues
     */
    public function testConvertToPHPValueToNull($dbValue)
    {
        $this->assertNull((new UrlType())->convertToPHPValue($dbValue, $this->platform));
    }

    public function testConvertToPHPValue(): void
    {
        $urlString = 'http://google.com';
        $url = (new UrlType())->convertToPHPValue($urlString, $this->platform);
        $this->assertEquals($urlString, $url->getUrl());
    }

    /**
     * @return array
     */
    public function getDbValues(): array
    {
        return [
            [ null ],
            [ 'foobar' ]
        ];
    }


    public function testConvertToDatabaseValue()
    {
        $urlString = 'http://google.com';
        $url = new Url($urlString);

        $this->assertEquals($urlString, (new UrlType())->convertToDatabaseValue($url, $this->platform));

        $this->assertNull((new UrlType())->convertToDatabaseValue($urlString, $this->platform));
    }
}
