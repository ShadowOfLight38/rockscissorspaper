<?php

namespace App\MyClasses;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableCell;
use Symfony\Component\Console\Helper\TableCellStyle;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Output\OutputInterface;

class GameHelpTableCommand extends Command
{
    protected function callHelp(OutputInterface $output): int
    {
        $table = new Table($output);
        $win = "You win";
        $lose = "Computer wins";
        $draw = "Draw";
        $table
            ->setHeaders([
                [new TableCell(
                    'Possible game results for 5 weapons (Rock-Scissors-Paper-Lizard-Spoke)',
                    [
                        'style' => new TableCellStyle([
                            'align' => 'center',
                        ]),
                        'colspan' => 6
                    ]
                )],
                ['Your weapon: \ Computer weapon:', 'Rock', 'Scissors', 'Paper', 'Lizard', 'Spoke'],
            ])
            ->setRows([
                ['Rock', $draw, $win, $win, $lose, $lose],
                new TableSeparator(),
                ['Scissors', $lose, $draw, $win, $win, $lose],
                new TableSeparator(),
                ['Paper', $lose, $lose, $draw, $win, $win],
                new TableSeparator(),
                ['Lizard', $win, $lose, $lose, $draw, $win],
                new TableSeparator(),
                ['Spoke', $win, $win, $lose, $lose, $draw]
            ]);
        $output->writeln("Both You and computer pick one weapon of your choice.");
        $output->writeln("Each weapon is stronger than the following half of weapons and is weaker " .
            "than previous half of weapons (weapons order is looped).");
        $output->writeln("For example, if we have 5 possible weapons then game results would be as follows:");
        $table->setStyle('box-double');
        $table->render();

        return Command::SUCCESS;
    }
}
