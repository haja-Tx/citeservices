<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 13/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes;

use JeckelLab\AdvancedTypes\DependencyInjection\AdvancedTypesExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class JeckelLabCommandDispatcherBundle
 */
class JeckelLabAdvancedTypesBundle extends Bundle
{
    /**
     * @return AdvancedTypesExtension|ExtensionInterface|null
     */
    public function getContainerExtension()
    {
        return new AdvancedTypesExtension();
    }
}
