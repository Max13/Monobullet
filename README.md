# Max13/Monobullet [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/max13/Monobullet/master/LICENSE)

[![Build Status](https://travis-ci.org/Max13/Monobullet.svg?branch=master)](https://travis-ci.org/Max13/Monobullet)

`Monobullet` is simply a [`Pushbullet`](http://pushbullet.com) handler for [Monolog](https://github.com/Seldaek/monolog). It will send you (or someone else, or many people) a push when your app logs something.

It includes a nice formatter for when logging an `Exception` and its stack.

For the record, `Pushbullet` is a platform allowing you to send a push to one or multiple devices using the mobile app, the web app or REST APIs.


## Installation

You can install the latest version with:

    $ composer require max13/monobullet


### Laravel 5.2 and above/similars

Add these lines to your `config/services.php`:

```php
'monobullet' => [
    'token' => 'YOUR PUSHBULLET TOKEN',
    'name' => 'NAME OF YOUR APP',
    'recipients' => 'email',
    'level' => Monolog\Logger::INFO,
    'propagate' => true,
    'env' => ['staging', 'production'],
],
```

Here are the variables references:

* `token`: Your Pushbullet api token.
* `name`: The name of your app, will be used to make the push's title.
* `recipients`: Can either be 1 email address, or an array of email addresses.
* `level`: Minimum level to take care. The default is `Monolog\Logger:INFO`.
* `propagate`: When `false`, if a record is handled, it won't be propagated to other handlers.
* `env`: Can either be 1 environment name (like `production`) or an array of environment name.

Then, add this line to Laravel's `config/app.php`, inside the `providers` array:

```php
    Monobullet\MonobulletServiceProvider::class,
```

/!\ Note that when using Service Provider, `Monobullet` will be set on the top of the `Monolog's` handlers, so the `bubble` parameter is important. After that you're good to go!

### Other frameworks

Put this wherever your framework's doc is telling you to do (`parameters` references are above):

```php
use Monobullet\PushbulletHandler;
// or: use Monobullet\Handler;
use Monolog\Logger;

$logger = new Logger('NAME'); // Will be used as the title of the push
$logger->pushHandler(new PushbulletHandler('PUSHBULLET_TOKEN', $recipients, $level = Logger::INFO, $bubble = false));
$logger->info('This is just a test log'); // You will receive a push saying this content
```

## Issues/PRs/Questions

Feel free to open an issue if you need anything. The same way, don't hesitate to send PRs ;)

When sending a PR, don't forget to add your name in the "Contributors" section of this README.

## Authors

Currently, I'm the only author of this package:

* Adnan RIHAN

## Contributors

* None (yet)
