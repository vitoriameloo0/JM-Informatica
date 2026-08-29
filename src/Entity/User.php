<?php

namespace src\Entity;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private bool $ativo;

    public function __construct(string $name = '', string $email = '', string $password = '', bool $ativo = true)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->ativo = $ativo;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getAtivo(): bool
    {
        return $this->ativo;
    }

    public function setAtivo(bool $ativo): void     
    {
        $this->ativo = $ativo;

    }
}