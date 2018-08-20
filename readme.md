# laravel-package-maker

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/naoray/laravel-package-maker.svg?style=flat-square)](https://packagist.org/packages/naoray/laravel-package-maker)

I hate creating new controllers, middlewares, ... by copy & paste. Wouldn't it be cool to have all the `make` commands you use in your daily Laravel app development workflow also for developing new packages? This package was created solely for the purpose to make package development as fast and easy as possible. Creating a new package only takes one command (`make:package`) and you will end up with the following file structure:

```bash
.
└── package
    ├── .codecov.yml
    ├── composer.json
    ├── CONTRIBUTING.md
    ├── .gitignore
    ├── LICENSE.md
    ├── phpunit.xml
    ├── readme.md
    ├── src
    │   └── PackageServiceProvider.php
    ├── .styleci.yml
    ├── tests
    │   └── TestCase.php
    └── .travis.yml
```

## Install
`composer require naoray/laravel-package-maker --dev`

## Usage
- [Package Internals](#internals)
    + [Create a package](#internals-create)
    + [Add a package](#internals-add)
    + [Save package credentials](#internals-save)
	+ [Delete package credentials](#internals-delete)
	+ [Commands used for creating initial package stubs](#internals-stubs)
- [Commands you already know](make-commands)
	+ [Foundation](make-commands-foundation)
	+ [Database](make-commands-database)
	+ [Routing](make-commands-routing)

<a name="internals"/>

### Package Internals

<a name="internals-create"/>

#### Create a package
```
php artisan make:package
```

![make:package](https://user-images.githubusercontent.com/10154100/44323501-89bdf000-a452-11e8-8fc4-3ec5c451c30a.gif)

<a name="internals-add"/>

#### Add a package
```
php artisan package:add
```
If you have already created a package or you want to add a modified version of a package which is currently only available locally, you can use the following command to add you package to your project. It does simply add your package to your project`s composer repositories and requires a local version of it.

**This command is run by `make:package` automatically, so you have no need to execute it after creating a package!**

<a name="internals-save"/>

#### Save package credentials
```
php artisan package:save
				{namespace : Root namespace of the package (Vendor\Package_name)}
				{path : Relative path to the package's directory}
```
Every `make:package:*` command needs to know the package's *namespace* and the relative *path* to the location your package is stored. Because of that every `make:package:*` command comes with those two options by default. To avoid entering those two options every time a `make:package:*` command executed this command saves the credentials of your package in the cache.

<a name="internals-delete"/>

#### Delete package credentials
```
php artisan package:delete
```
This one wipes all stored credentials from your cache.

<a name="internals-stubs"/>

#### Commands used for creating initial package stubs
- `make:package:basetest {provider : The package's provider name}` - creates `TestCase` in `tests` folder
- `make:package:codecov` - creates a `.codecov.yml` file
- `make:package:composer {author : The author of the package.} {email : The author's email.}` - creates `composer.json`
- `make:package:contribution` - creates `CONTRIBUTING.md`
- `make:package:gitignore` - creates `.gitignore` file
- `make:package:license {--copyright : The company or vendor name to place it int the license file}` - creates `LICENSE.md` file
- `make:package:phpunit` - creates `phpunit.xml`
- `make:package:readme` - creates `readme.md`
- `make:package:styleci` - creates `.styleci.yml`
- `make:package:travis` - creates `.travis.yml`

<a name="make-commands"/>

### Commands you already know
*Use a few `make` commands*
![make:package:*](https://user-images.githubusercontent.com/10154100/44323506-8cb8e080-a452-11e8-9f7c-fb07462c9b96.gif)

*All arguments & options you know from the standard `make` commands are available. Create a model with all option.*
![make:package:model --all](https://user-images.githubusercontent.com/10154100/44323509-8f1b3a80-a452-11e8-9a98-1ecaa96b1ae6.gif)

All of these commands do have all arguments & options to which you are used to in a normal laravel app! To execute any of these commands simply add the prefix `make:package:`.

<a name="make-commands-foundation"/>

#### Foundation
- `channel`
- `console`
- `event`
- `exception`
- `job`
- `listener`
- `mail`
- `model`
- `notification`
- `observer`
- `policy`
- `provider`
- `request`
- `resource`
- `rule`
- `test`

<a name="make-commands-database"/>

#### Database
- `factory`
- `migration`
- `seeder`

<a name="make-commands-routing"/>

#### Routing
- `controller`
- `middleware`

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