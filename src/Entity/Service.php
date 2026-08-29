<?php

namespace src\Entity;

class Service
{
    private int $id_service;
    private string $description;
    private float $price;
    private string $finished;
    private float $commission;

    public function getId(): ?int
    {
        return $this->id_service;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
    
    public function getFinished(): ?string
    {
        return $this->finished;
    }

    public function setFinished(string $finished): self
    {
        $this->finished = $finished;

        return $this;
    }

    public function getCommission(): ?float
    {
        return $this->commission;
    }

    public function setCommission(float $commission): self
    {
        $this->commission = $commission;

        return $this;
    }
}