<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use JeckelLab\AdvancedTypes\DBAL\Types\EmailType;
use JeckelLab\AdvancedTypes\ValueObject\Email;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTypeTest
 * @package Tests\JeckelLab\AdvancedTypes\DBAL\Types
 */
class EmailTypeTest extends TestCase
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
        $this->assertNull((new EmailType())->convertToPHPValue($dbValue, $this->platform));
    }

    public function testConvertToPHPValue(): void
    {
        $emailString = 'foo@bar.com';
        $email = (new EmailType())->convertToPHPValue($emailString, $this->platform);
        $this->assertEquals($emailString, $email->getEmail());
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

    public function testConvertToDatabaseValue(): void
    {
        $emailString = 'foo@bar.com';
        $email = new Email($emailString);

        $this->assertEquals($emailString, (new EmailType())->convertToDatabaseValue($email, $this->platform));

        $this->assertNull((new EmailType())->convertToDatabaseValue($emailString, $this->platform));
    }
}
