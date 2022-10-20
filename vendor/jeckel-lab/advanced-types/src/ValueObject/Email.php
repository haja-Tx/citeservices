<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at: 08/01/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;

/**
 * Class Email
 * @package JeckelLab\AdvancedTypes\emailObject
 * @psalm-immutable
 */
class Email implements ValueObject, Equality
{
    /** @var string */
    protected $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        Assert::that($email)->email();
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return $object->email === $this->email;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }
}
