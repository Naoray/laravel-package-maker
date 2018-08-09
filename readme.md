# laravel-package-maker

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/naoray/laravel-package-maker.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/naoray/laravel-package-maker.svg?style=flat-square)](https://packagist.org/packages/naoray/laravel-package-maker)

Developing packages with laravel is easy, but the process of creating the project folders, initializing composer, readme
contribution guide, ... You get the point. This Package comes with two useful commands to create/use packages locally and serves as a quick package stub generator. With only one command you can create a new package with
- Ready to use Composer file
- License file (currently only MIT)
- Contribution guidelines
- .travis.yml
- phpunit.xml
- .styleci.yml
- .gitignore
- tests folder
- base TestCase Class using Orchestra Testbench
- Service Provider

... and your newly created package gets directly pulled in your project via composer repositories.

```
php artisan make:package
```

![make:package command](https://user-images.githubusercontent.com/10154100/43901805-b14e9e02-9be8-11e8-9617-6999509fb0d5.png)

## Install
`composer require naoray/laravel-package-maker --dev`

## Usage
### Creating a new package
*To see all arguments/options available for make:package just type `php artisan package:make -h`*
```
php artisan make:package
```

![make:package command](https://user-images.githubusercontent.com/10154100/43901805-b14e9e02-9be8-11e8-9617-6999509fb0d5.png)

### Adding a package
If you have already created a package or you want to add a modified version of a package which is currently only available locally, you can use the following command to add you package to your project.

```
php artisan package:add
```

![package:add command](https://user-images.githubusercontent.com/10154100/43901825-bc2fb91e-9be8-11e8-9142-c44558c9303c.png)

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security-related issues, please email krishan.koenig@googlemail.com instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.