<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 18/11/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use JeckelLab\AdvancedTypes\ValueObject\TimeDuration;

/**
 * Class TimeDurationType
 * @package JeckelLab\AdvancedTypes\DBAL\Types
 */
class TimeDurationType extends Type
{
    protected const TIME_DURATION_TYPE = 'time_duration';

    /**
     * @param mixed[]          $fieldDeclaration
     * @param AbstractPlatform $platform
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform): string
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::TIME_DURATION_TYPE;
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return TimeDuration
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): TimeDuration
    {
        if (null === $value) {
            return new TimeDuration();
        }
        return new TimeDuration((int) $value);
    }

    /**
     * @param mixed            $value
     * @param AbstractPlatform $platform
     * @return int|null
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        if ($value instanceof TimeDuration) {
            return $value->getValue();
        }
        return null;
    }
}
