# Autobake plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require ivyhjk/Autobake
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
	            'host' => '192.168.0.111',
	            'username' => 'elvis',
	            'password' => 'elviselvis',
	            'database' => 'autobake',
	            'encoding' => 'utf8',
	            'timezone' => 'UTC',
	            'prefix' => 'my_prefix_',
	        ],
	    ],
	```