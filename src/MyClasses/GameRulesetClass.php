<?php

namespace App\MyClasses;

class GameRulesetClass
{
    private string $secretKey;
    private string $computerMove;
    private string $hmacKey;
    private array $possibleWeapons;
    private int $weaponsQuantity;

    public function __construct(array $possibleWeapons)
    {
        $this->possibleWeapons = $possibleWeapons;
        $this->weaponsQuantity = count($possibleWeapons);
        $this->generateComputerMove($this->possibleWeapons);
        $this->generateSecretKey();
        $this->buildHmacKey($this->getComputerMove(), $this->getSecretKey());
    }
    public function getComputerMove(): string
    {
        return $this->computerMove;
    }
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
    public function getHmacKey(): string
    {
        return $this->hmacKey;
    }
    public function calculateResultOfGame(string $computerMove, string $playerMove): string
    {
        $compEval = array_search($computerMove, $this->possibleWeapons);
        $playerEval = array_search($playerMove, $this->possibleWeapons);

        // TODO: Replace placeholder below with real logic
        // --- <Placeholder>
        if ($compEval < $playerEval) {
            $result = 'You lose!';
        } else {
            $result = 'You win!';
        }
        // --- </Placeholder>

        return $result;
    }
    public function generateComputerMove($weapons): void
    {
        $this->computerMove = $weapons[array_rand($weapons)];
    }
    public function generateSecretKey(): void
    {
        $this->secretKey = hash('sha3-256', mt_rand());
    }
    public function buildHmacKey(string $computerMove, string $secretKey): void
    {
//        echo "Computer move: " . $computerMove . PHP_EOL; echo "Secret key: " . $secretKey . "\n";
        $this->hmacKey = hash_hmac('sha3-256', $computerMove, $secretKey);
    }
}
