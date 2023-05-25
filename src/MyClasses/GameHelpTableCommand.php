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
        $win = new TableCell('You win', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'green',
        ])
        ]);
        $lose = new TableCell('Computer wins', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'red',
        ])
        ]);
        $draw = new TableCell('Draw', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'yellow',
        ])
        ]);
        $table
            ->setHeaders([
                [new TableCell(
                    'Possible game results for 5 moves (Rock-Scissors-Paper-Lizard-Spoke)',
                    [
                        'style' => new TableCellStyle([
                            'align' => 'center',
                        ]),
                        'colspan' => 6
                    ]
                )],
                [
                    new TableCell("Your move:", [
                        'style' => new TableCellStyle([
                            'align' => 'center',
                        ]),

                    ]),
                    new TableCell('Computer move:', [
                    'style' => new TableCellStyle([
                        'align' => 'center',
                    ]),
                    'colspan' => 5
                    ])
                ],
            ])
            ->setRows([
                ['', 'Rock', 'Scissors', 'Paper', 'Lizard', 'Spoke'],
                new TableSeparator(),
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
        $output->writeln([
            str_repeat("-", 15) . " Help desk " . str_repeat("-", 15),
            "How to play the game?",
            "Both You and computer pick one weapon of your choice.",
            "Each weapon is stronger than the following half of weapons and is weaker " .
            "than previous half of weapons. Weapons order is looped i.e.:",
            "... < Weapon 3 < Weapon 1 < Weapon 2 < Weapon 3 < Weapon 1 < ...",
            "For example, if we have 5 possible weapons then game results would be as follows:"
            ]
        );
        $table->setStyle('box-double');
        $table->render();

        return Command::SUCCESS;
    }
}
