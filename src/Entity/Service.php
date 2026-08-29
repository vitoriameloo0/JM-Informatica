<?php

namespace src\Entity;

use IntlChar;

class Service
{
    private int $id_service;
    private string $description;
    private float $price;
    private string $finished;
    private float $commission;

    public function getId(): int
    {
        return $this->id_service;
    }

    public function setId(int $id_service):void
    {
        $this->id_service = $id_service;
    }
    
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    
    public function getFinish(): string
    {
        return $this->finished;
    }

    public function setFinish(string $finished): void
    {
        $this->finished = $finished;
    }

    public function getCommission(): float
    {
        return $this->commission;
    }

    public function setCommission(float $commission): void
    {
        $this->commission = $commission;
    }
}