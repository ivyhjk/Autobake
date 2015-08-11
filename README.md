# Autobake plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

``` bash
$ composer require ivyhjk/autobake
```

## Plugin activation

``` bash
$ bin/cake plugin load Autobake
```

# autobake

Autobake can "auto-generate" all your models, controllers and views from a given database, previously established in your App/config/app.php file.

- It's based on CakePHP Bake console, but better and fast!.
- Support table prefixes for bake, just add 'prefix' => 'my_prefix_' to your database config.
	For example:

```php
	'Datasources' => [
	        'default' => [
	            'className' => 'Cake\Database\Connection',
	            'driver' => 'Cake\Database\Driver\Mysql',
	            'host' => '127.0.0.1',
	            'username' => 'username',
	            'password' => 'y0ur53c3t7p4s5w0rD',
	            'database' => 'autobake',
	            'encoding' => 'utf8',
	            'timezone' => 'UTC',
	            'prefix' => 'my_prefix_',
	        ],
	    ],
```


# Usage

#### Baking models
``` bash
./cake prepare auto_model users
```

#### Baking controllers
``` bash
./cake prepare auto_controller --prefix myprefix users
```

#### Baking templates
``` bash
./cake prepare auto_template --prefix myprefix users
```

#### And the most powerfull tool: baking all, with prefix :).
``` bash
./cake prepare all --prefix myprefix users
```
