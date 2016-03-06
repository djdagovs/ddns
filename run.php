#!/usr/bin/env php
<?php
require 'vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

use Symfony\Component\Console\Application;
use Ddns\DdnsCommand;

$app = new Application;
$app->add(new DdnsCommand);
$app->run();
