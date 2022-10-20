<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

namespace Tests\JeckelLab\AdvancedTypes\ValueObject;

use Assert\InvalidArgumentException;
use JeckelLab\AdvancedTypes\ValueObject\Email;
use PHPUnit\Framework\TestCase;

/**
 * Class EmailTest
 * @package Tests\JeckelLab\AdvancedTypes\ValueObject
 */
class EmailTest extends TestCase
{
    /**
     * @dataProvider getInvalidEmails
     * @param $email
     */
    public function testConstructWithInvalidEmails($email): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email($email);
    }

    /**
     * @return array
     */
    public function getInvalidEmails(): array
    {
        return [
            ['foobar'],
            ['']
        ];
    }

    public function testGetEmail(): void
    {
        $emailString = 'foo@bar.com';
        $email = new Email($emailString);
        $this->assertEquals($emailString, $email->getEmail());
        $this->assertEquals($emailString, $email->__toString());
    }
}
