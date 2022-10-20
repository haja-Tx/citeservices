<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 27/02/2020
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\ValueObject;

/**
 * Interface ValueObject
 * @package JeckelLab\AdvancedTypes\ValueObject
 * @psalm-immutable
 */
interface ValueObject
{
    /**
     * @return string
     */
    public function __toString(): string;
}
