<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 14/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\Enum;

use JeckelLab\AdvancedTypes\ValueObject\ValueObject;
use JsonSerializable;
use MabeEnum\Enum;

/**
 * Class EnumAbstract
 * @package JeckelLab\AdvancedTypes\Enum
 * @psalm-immutable
 */
abstract class EnumAbstract extends Enum implements JsonSerializable, ValueObject
{
    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $value = $this->getValue();
        if (is_string($value)) {
            return $value;
        }
        return parent::__toString();
    }
}
