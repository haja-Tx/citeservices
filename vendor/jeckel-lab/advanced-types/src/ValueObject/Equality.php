<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 27/02/2020
 */

namespace JeckelLab\AdvancedTypes\ValueObject;

/**
 * Interface Equality
 * @package JeckelLab\AdvancedTypes\ValueObject
 */
interface Equality
{
    /**
     * @param static $object
     * @return bool
     */
    public function equals($object): bool;
}
