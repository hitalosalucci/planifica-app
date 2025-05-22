<?php

namespace App\DTOs\User;
use App\DTOs\BaseDTO;

class UpdateUserDTO extends BaseDTO
{
    public function __construct(
        public ?string $name = null,
        public ?string $email = null,
        public ?string $password = null
    ) {}

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
            'password' => 'sometimes|nullable|min:8'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ], fn($value) => !is_null($value)); //criará um array somente com os objetos diferentes de null, ou seja, os objetos que serão atualizados
    }
}
