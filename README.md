# Laasti/valitron-provider

A league/container service provider for vlucas/valitron.

## Installation

```
composer require laasti/valitron-provider
```

## Usage

```php

$container = new League\Container\Container;
$container->add('config.validation', [
    'locale' => 'fr',//if not specified, attempts to use config.locale in the container, defaults to en,
    'locales_dir' => __DIR__,//defaults, to valitrons language files directory
    //Additional rules to add to Valitron, any php callbacks are accepted
    'rules' => [
        ['my_rule', 'my_callback', 'My message']
    ]
]);
$container->addServiceProvider('Laasti\ValitronProvider\ValitronProvider');

//The arguments are the same as Valitron's constructor
$validator = $container->get('Valitron\Validator', [$data]);

```

## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D

## History

See CHANGELOG.md for more information.

## Credits

Author: Sonia Marquette (@nebulousGirl)

## License

Released under the MIT License. See LICENSE.txt file.