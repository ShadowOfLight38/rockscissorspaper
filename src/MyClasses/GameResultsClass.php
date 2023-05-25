<?php

namespace App\MyClasses;

class GameResultsClass
{
    private array $moves;
    private string $computerMove;
    private string $userMove;
    private int $computerMovePosition;
    private int $userMovePosition;
    public function __construct(array $moves, string $computerMove, string $userMove)
    {
        $this->moves = $moves;
        $this->computerMove = $computerMove;
        $this->userMove = $userMove;
        $this->computerMovePosition = array_search($computerMove, $moves);
        $this->userMovePosition = array_search($userMove, $moves);
    }
    public function show(): void
    {
        echo "--- Information from GameResultsClass: ---" . PHP_EOL;
        echo "Possible variants: " . PHP_EOL;
        echo PHP_EOL . "Computer move: " . $this->computerMove . PHP_EOL;
        echo "User move: " . $this->userMove . PHP_EOL;
        echo "Computer's move position: " . $this->computerMovePosition . PHP_EOL;
        echo "--- End of information ---" . PHP_EOL;
    }
    public function showResults(string $computerMove, string $userMove): string
    {
        if ($computerMove === $userMove) {
            return "\e[93mDraw!\e[39m";
        } else {
            return $this->calculateResult($this->computerMovePosition, $this->userMovePosition);
        }
    }
    private function calculateResult(int $computerMove, int $userMove): string
    {
        if ($userMove < $computerMove) {
            return (abs($userMove - $computerMove) < count($this->moves)/2) ? "\e[32mYou win!\e[39m" : "\e[31mYou lose!\e[39m";
        } else {
            return (abs($userMove - $computerMove) >= count($this->moves)/2) ? "\e[32mYou win!\e[39m" : "\e[31mYou lose!\e[39m";
        }
    }
}
