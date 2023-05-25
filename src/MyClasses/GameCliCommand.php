<?php

namespace App\MyClasses;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use App\MyClasses\GameRulesetClass;

class GameCliCommand extends GameHelpTableCommand
{
    private array $possibleUserChoices;
    protected function configure(): void
    {
        $this->setName('app:game')
            ->setDescription('Launches game of Rock-Scissors-Paper')
            ->setHelp('To successfully launch the game you should add 3 or more odd (3, 5, 7 etc.) weapons.' .
            PHP_EOL . "Computer will randomly pick one weapon. After that you would choose your own weapon." .
            PHP_EOL . "Results of the battle will be calculated and shown with proofs that computer does not cheat." .
            PHP_EOL . "You could check fairness of computer by checking HMAC on special sites, for example " .
            "http://techiedelight.com/tools/hmac")
            ->addArgument(
                'weapons',
                InputArgument::IS_ARRAY,
                'Please enter odd quantity of weapons you would like to use in game(separate with a space)'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        if ($input->getArgument('weapons') !== array_unique($input->getArgument('weapons'))) {
            $output->writeln([
                'All weapons should be unique!',
                "Correct: 'Rock Paper Scissors' or '1 2 3'. Incorrect: 'Rock Paper Rock' or '1 2 2'."
            ]);
        } elseif (count($input->getArgument('weapons')) < 3) {
            $output->writeln('Please enter at least three weapons to launch the game.');
        } elseif (count($input->getArgument('weapons'))%2 === 0) {
            $output->writeln("You should enter odd quantity of unique weapons (3, 5, 7 etc.)!");
        } else {
            $object = new GameRulesetClass($input->getArgument('weapons'));
            $output->writeln([
                'Welcome to the game of Rock-Scissors-Paper!',
                'Computer has chosen his move!',
                'HMAC: ' . $object->getHmacKey(),
                'Available moves:'
            ]);

            $this->setUpPossibleUserChoices($input);

            foreach ($this->possibleUserChoices as $id => $choice) {
                $output->writeln($id . " - " . $choice);
            }
            $requestForUserChoice = new Question(
                'Please choose a move (number) to fight computer: '
            );
            $requestForUserChoice->setValidator(function ($answer)
                {
                    if (!array_key_exists($answer, $this->possibleUserChoices)) {
                        throw new \RuntimeException(
                            "Please enter number of move, '0' to exit or '?' to show help."
                        );
                    }
                    return $answer;
                }
            );
            $requestForUserChoice->setMaxAttempts(null);
            $userChoice = $helper->ask($input, $output, $requestForUserChoice);

            if ($userChoice === "0") {
                echo "Thank you for playing! Come again!";
            } elseif ($userChoice === '?') {
                $help = new GameHelpTableCommand();
                $help->callHelp($output, $input->getArgument('weapons'));
            } else {
                $userMove = $this->possibleUserChoices[$userChoice];
                $resultClass = new GameResultsClass(
                    $input->getArgument('weapons'),
                    $object->getComputerMove(),
                    $userMove
                );
                echo "Your move: \e[96m" . $userMove . "\e[39m\n";
                echo "Computer move: \e[96m" . $object->getComputerMove() . "\e[39m\n";
                echo $resultClass->showResults($object->getComputerMove(), $userMove) . PHP_EOL;
                echo "HMAC key: " . $object->getSecretKey() . PHP_EOL;
            }

        }
        return Command::SUCCESS;
    }

    private function setUpPossibleUserChoices(InputInterface $input): void
    {
        foreach ($input->getArgument('weapons') as $id => $weapon) {
            $this->possibleUserChoices[$id+1] = $weapon;
        }
        $this->possibleUserChoices['0'] = 'exit';
        $this->possibleUserChoices['?'] = 'help';
    }
}
