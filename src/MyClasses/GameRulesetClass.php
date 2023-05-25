<?php

namespace App\MyClasses;

class GameRulesetClass
{
    private string $secretKey;
    private string $computerMove;
    private string $hmacKey;
    private array $possibleWeapons;
    public function __construct(array $possibleWeapons)
    {
        $this->possibleWeapons = $possibleWeapons;
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
    public function generateComputerMove(array $weapons): void
    {
        $this->computerMove = $weapons[array_rand($weapons)];
    }
    public function generateSecretKey(): void
    {
        $this->secretKey = hash('sha3-256', mt_rand());
    }
    public function buildHmacKey(string $computerMove, string $secretKey): void
    {
        $this->hmacKey = hash_hmac('sha3-256', $computerMove, $secretKey);
    }
}
