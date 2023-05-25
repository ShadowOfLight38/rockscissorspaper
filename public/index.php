<?php

require '../vendor/autoload.php';

use App\MyClasses\GameCliCommand;
use Symfony\Component\Console\Application;

$obj = new Application();
$obj->add(new GameCliCommand());
$obj->run();

