<?php

namespace App\MyClasses;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use App\MyClasses\GameRulesetClass;
use Symfony\Component\Console\Exception\RuntimeException;


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
        foreach ($input->getArgument('weapons') as $id => $weapon) {
            $this->possibleUserChoices[$id+1] = $weapon;
        }
        $this->possibleUserChoices['0'] = 'exit';
        $this->possibleUserChoices['?'] = 'help';

        $helper = $this->getHelper('question');
        if (count($input->getArgument('weapons')) < 3) {
            $output->writeln('Please enter at least three weapons to launch the game.');
        } elseif (count($input->getArgument('weapons'))%2 === 0) {
            $output->writeln('You should enter odd quantity of weapons (3, 5, 7 etc.)!');
        } else {
            $object = new GameRulesetClass($this->possibleUserChoices);
            $output->writeln('Welcome to the game of Rock-Scissors-Paper!');
            $output->writeln('Computer has chosen the weapon to use!');
            $output->writeln('HMAC: ' . $object->getHmacKey());
            $output->writeln('Available moves:');
            foreach ($this->possibleUserChoices as $id => $choice) {
                $output->writeln($id . " - " . $choice);
            }
            $question = new Question(
                'Please choose a weapon (write weapon number) to fight computer: '
            );
            $question->setValidator(function ($answer)
                {
                    if (!array_key_exists($answer, $this->possibleUserChoices)) {
                        throw new RuntimeException(
                            "Please enter number of move or '?'."
                        );
                    }

                    return $answer;
                }
            );
            $question->setMaxAttempts(null);
            $userMove = $helper->ask($input, $output, $question);

            if ($userMove === "0") {
                echo "Thank you for playing! Come again!";
            } elseif ($userMove === '?') {
                $help = new GameHelpTableCommand();
                $help->callHelp($output);
            } else {
                $output->writeln($object->calculateResultOfGame($object->getComputerMove(), $userMove));
            }

        }
        return Command::SUCCESS;
    }
}
