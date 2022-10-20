<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 05/12/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

use Assert\Assert;

/**
 * Class Url
 * @package JeckelLab\AdvancedTypes\ValueObject
 * @psalm-immutable
 */
class Url implements ValueObject, Equality
{
    /** @var string */
    protected $url;

    /**
     * Url constructor.
     * @param string $url
     */
    public function __construct(string $url)
    {
        Assert::that($url)->url();
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool
    {
        return ($object instanceof self) && ($object->url === $this->url);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }
}
