[![CircleCI](https://circleci.com/gh/Jeckel-Lab/advanced-types.svg?style=svg)](https://circleci.com/gh/Jeckel-Lab/advanced-types)
[![Latest Stable Version](https://poser.pugx.org/jeckel-lab/advanced-types/v/stable)](https://packagist.org/packages/jeckel-lab/advanced-types) [![Total Downloads](https://poser.pugx.org/jeckel-lab/advanced-types/downloads)](https://packagist.org/packages/jeckel-lab/advanced-types)
[![Build Status](https://travis-ci.org/Jeckel-Lab/advanced-types.svg?branch=master)](https://travis-ci.org/Jeckel-Lab/advanced-types)
[![codecov](https://codecov.io/gh/jeckel-lab/advanced-types/branch/master/graph/badge.svg)](https://codecov.io/gh/jeckel-lab/advanced-types)
[![Dependabot Status](https://api.dependabot.com/badges/status?host=github&repo=Jeckel-Lab/advanced-types)](https://dependabot.com)

# Advanced PHP Types

- **Enum** (based on [marc-mabe/php-enum](https://github.com/marc-mabe/php-enum))

# Installation

```bash
composer require jeckel-lab/advanced-types
```

# Types

## Enum

See documentation of [marc-mabe/php-enum](https://github.com/marc-mabe/php-enum).

> The only addition is the implementation of `JsonSerializable` interface to serialize enum as it's value.

# Value Object

- Color
- DateTimePeriod
- Email
- TimeDuration
- Url

## Usage with doctrine

Configure type DBAL:

```yaml
# config/packages/doctrine.yaml

doctrine:
    dbal:
        types:
            color: JeckelLab\AdvancedTypes\DBAL\Types\ColorType
            email: JeckelLab\AdvancedTypes\DBAL\Types\EmailType
            time_duration: JeckelLab\AdvancedTypes\DBAL\Type\sTimeDurationType
            url: JeckelLab\AdvancedTypes\DBAL\Types\UrlType
```

Use it in your entity:

```php
<?php

use Doctrine\ORM\Mapping as ORM;
use JeckelLab\Types\ValueObject\TimeDuration;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TimeEntryRepository")
 */
class TimeEntry
{
    // ...

    /**
     * @ORM\Column(type="time_duration", nullable=true)
     * @var TimeDuration|null
     */
    private $duration;

    // ...
}
```
