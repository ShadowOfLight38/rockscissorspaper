<?php

require '../vendor/autoload.php';

use App\MyClasses\GameCliCommand;
use Symfony\Component\Console\Application;
use App\MyClasses\GameRulesetClass;

$weapons = ["Rock", "Scissors", "Paper", "Lizard", "Spoke"];
$obj = new GameRulesetClass($weapons);

$computerMove = $obj->getComputerMove();
$secretKey = $obj->getSecretKey();
$hmacKey = $obj->getHmacKey();

echo "Computer move:\n";
print_r($computerMove . PHP_EOL);
echo "Secret key:\n";
print_r($secretKey . PHP_EOL);
echo "HMAC:\n";
print_r($hmacKey . PHP_EOL);
echo "Your move: Paper" . PHP_EOL;
echo "According to current ruleset ";
print_r($obj->calculateResultOfGame($computerMove, "Paper") . " (we will fix issues soon)" . PHP_EOL);

//$obj = new Application();
//$obj->add(new GameCliCommand());
//$obj->run();

