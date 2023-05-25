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
    private array $rows;
    private object $win;
    private object $lose;
    private object $draw;
    protected function callHelp(OutputInterface $output, array $moves): int
    {
        $table = new Table($output);
        $this->buildPossibleResults();
        $headerRow = $moves;
        array_unshift($headerRow, "");

        $this->buildTableRows($moves);
        $table
            ->setHeaders([
                [new TableCell(
                    "Possible game results for " . count($moves) . " moves",
                    [
                        'style' => new TableCellStyle([
                            'align' => 'center',
                        ]),
                        'colspan' => count($moves)+1
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
                    'colspan' => count($moves)
                    ])
                ],
            ])
            ->setRows([
                $headerRow
            ]);
        for ($i = 0; $i < count($moves); $i++) {
            $table->addRow(new TableSeparator());
            $table->addRow($this->rows[$i]);
        }
        $table->setStyle('box-double');
        $table->render();

        return Command::SUCCESS;
    }

    private function buildTableRows(array $moves): void
    {
        for ($i = 0; $i < count($moves); $i++) {
            $weapon[$i] = new TableCell($moves[$i], ['style' => new TableCellStyle([
                'align' => 'center',
            ])
            ]);
            for ($j = 0; $j < count($moves); $j++) {
                if ($i === $j) {
                    $this->rows[$i][$j] = $this->draw;
                } elseif ($i < $j) {
                    $this->rows[$i][$j] = (abs($i - $j) < count($moves) / 2) ? $this->win : $this->lose;
                } else {
                    $this->rows[$i][$j] = (abs($i - $j) >= count($moves) / 2) ? $this->win : $this->lose;
                }
            }
            array_unshift($this->rows[$i], $weapon[$i]);
        }
    }
    private function buildPossibleResults(): void
    {
        $this->win = new TableCell('You win', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'green',
        ])
        ]);
        $this->lose = new TableCell('Computer wins', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'red',
        ])
        ]);
        $this->draw = new TableCell('Draw', ['style' => new TableCellStyle([
            'align' => 'center',
            'bg' => 'gray',
        ])
        ]);

    }
}
