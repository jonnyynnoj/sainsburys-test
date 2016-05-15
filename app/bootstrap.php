<?php

use Illuminate\Container\Container;
use jonnyynnoj\Sainsburys\ServiceProvider;

// require composer vendor autoload
require __DIR__ . '/../vendor/autoload.php';

// create DI container instance
$container = new Container;

// load service provider
$provider = new ServiceProvider($container);
$provider->register();
