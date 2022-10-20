[![Latest Stable Version](https://poser.pugx.org/jeckel-lab/clock/v/stable)](https://packagist.org/packages/jeckel-lab/clock)
[![Total Downloads](https://poser.pugx.org/jeckel-lab/clock/downloads)](https://packagist.org/packages/jeckel-lab/clock)
[![Build Status](https://travis-ci.org/jeckel-lab/clock.svg?branch=master)](https://travis-ci.org/jeckel-lab/clock)

# Clock

A clock abstraction library for PHP which allow to mock system clock when testing

# Installation

```bash
composer require jeckel-lab/clock
```

## Usage

In your code, always use the ClockInterface in your services when you need to access the current time. After that, you just had to define which implementation to use according to your environement (real or fake for tests).

In some framework, It can be easier to use the factory to handle the switch and inject the require configuration.

### Symfony 4

With SF4 we use the internal DI system with the factory. The factory will get different parameters according to the current environment.

Configure DI with a factory in `config/services.yaml`:
```yaml
# config/services.yaml
    JeckelLab\Clock\ClockInterface:
        factory: ['JeckelLab\Clock\ClockFactory', getClock]
        arguments: ['%fake_clock%', '%fake_clock_file%']
```
Configure default parameters in `config/packages/parameters.yaml`:
```yaml
# config/packages/parameters.yaml
parameters:
    fake_clock: false
    fake_clock_file: '%kernel.project_dir%/var/clock'
```

And then configure parameters for **tests** environment in `config/packages/test/parameters.yaml`:
```yaml
# config/packages/test/parameters.yaml
parameters:
    fake_clock: true
```
