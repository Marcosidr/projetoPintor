<?php
declare(strict_types=1);

class User
{
    public function __construct(
        private string $nome,
        private string $email,
        private string $senha,
        private string $tipo = 'usuario' // pode ser 'usuario' ou 'admin'
    ) {}

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }
}
