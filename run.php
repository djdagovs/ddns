#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

use Symfony\Component\Console\Application;
use Ddns\DdnsCommand;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$app = new Application;
$app->add(new DdnsCommand);
$app->run();
