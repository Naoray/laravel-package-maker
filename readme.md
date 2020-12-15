# laravel-package-maker

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/naoray/laravel-package-maker.svg?style=flat-square)](https://packagist.org/packages/naoray/laravel-package-maker)

All the `make` commands you use in your daily Laravel app development workflow but for packages! This package was created solely for the purpose to make package development as fast and easy as possible. Creating a new package only takes one command (`make:package`) and you will end up with the following file structure:

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
- [laravel-package-maker](#laravel-package-maker)
  - [Install](#install)
  - [Usage](#usage)
    - [Create a package](#create-a-package)
    - [Create a nova tool](#create-a-nova-tool)
    - [Add a package](#add-a-package)
    - [Save package credentials](#save-package-credentials)
    - [Delete package credentials](#delete-package-credentials)
    - [Clone a package](#clone-a-package)
    - [Replace Content](#replace-content)
    - [Make Commands](#make-commands)
      - [Foundation](#foundation)
      - [Database](#database)
      - [Routing](#routing)
      - [Standard Php](#standard-php)
    - [Commands used for creating initial package stubs](#commands-used-for-creating-initial-package-stubs)
    - [Example Usage](#example-usage)
  - [Testing](#testing)
  - [Changelog](#changelog)
  - [Contributing](#contributing)
  - [Credits](#credits)
  - [Security](#security)
  - [License](#license)

<a name="internals-create"/>

### Create a package
```
php artisan make:package
```

![make:package](https://user-images.githubusercontent.com/10154100/44323501-89bdf000-a452-11e8-8fc4-3ec5c451c30a.gif)

<a name="internals-nova"/>

### Create a nova tool
```
php artisan make:nova
```

Inspired by [Spatie's nova-skeleton-tool](https://github.com/spatie/skeleton-nova-tool) this command clones the repository, replaces all strings with your own and adds it to your own project.

![make:nova](https://user-images.githubusercontent.com/10154100/44515270-5d100f80-a6c2-11e8-9a8c-a26e9a3af55d.png)

<a name="internals-add"/>

### Add a package
```
php artisan package:add
```
If you have already created a package or you want to add a modified version of a package which is currently only available locally, you can use the following command to add you package to your project. It does simply add your package to your project`s composer repositories and requires a local version of it.

**This command is run by `make:package` automatically, so you have no need to execute it after creating a package!**

<a name="internals-save"/>

### Save package credentials
```
php artisan package:save
				{namespace : Root namespace of the package (Vendor\Package_name)}
				{path : Relative path to the package's directory}
```
Every `package:*` command needs to know the package's *namespace* and the relative *path* to the location your package is stored. Because of that every `package:*` command comes with those two options by default. To avoid entering those two options every time a `package:*` command executed this command saves the credentials of your package in the cache.

<a name="internals-delete"/>

### Delete package credentials
```
php artisan package:delete
```
This one wipes all stored credentials from your cache.

<a name="internals-clone"/>

### Clone a package
```
php artisan package:clone
                {src : Source path of the package to clone}
                {target : Path where it should be cloned in}
```
The clone command clones a given repository or directory into the given target.

<a name="internals-replace"/>

### Replace Content
```
php artisan package:replace 
                {path : The path to a file or directory}
                {--O|old=* : Old strings which will be replaced}
                {--N|new=* : New strings which will be used as replacement}'
```
The replace command takes a path of a file or a directory and an indefinite number of 'old' options which will be replaced by the 'new' options.


<a name="make-commands"/>

### Make Commands
All of these commands do have all arguments & options to which you are used to in a normal laravel app! To execute any of these commands simply add the prefix `package:`.

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

<a name="make-standards">

#### Standard Php
All of the following routes only accept a `name` argument.

- `contract`
- `interface` (same as `contract`)
- `trait`

<a name="internals-stubs"/>

### Commands used for creating initial package stubs
- `package:basetest {provider : The package's provider name}` - creates `TestCase` in `tests` folder
- `package:codecov` - creates a `.codecov.yml` file
- `package:composer {--author : The author of the package.} {--email : The author's email.}` - creates `composer.json`
- `package:contribution` - creates `CONTRIBUTING.md`
- `package:gitignore` - creates `.gitignore` file
- `package:license {--copyright : The company or vendor name to place it int the license file}` - creates `LICENSE.md` file
- `package:phpunit` - creates `phpunit.xml`
- `package:readme {--author : The author of the package.} {--email : The author's email.}` - creates `readme.md`
- `package:styleci` - creates `.styleci.yml`
- `package:travis` - creates `.travis.yml`

<a name="make-commands-example-usage"/>

### Example Usage
*Use a few `make` commands*
![package:*](https://user-images.githubusercontent.com/10154100/44323506-8cb8e080-a452-11e8-9f7c-fb07462c9b96.gif)

*All arguments & options you know from the standard `make` commands are available. Create a model with all option.*
![package:model --all](https://user-images.githubusercontent.com/10154100/44323509-8f1b3a80-a452-11e8-9a98-1ecaa96b1ae6.gif)

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits
- [Krishan König](https://github.com/naoray)
- [All Contributors](https://github.com/naoray/laravel-package-maker/contributors)

## Security
If you discover any security-related issues, please email krishan.koenig@googlemail.com instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
