<?php

namespace App\DTOs\User;
use App\DTOs\BaseDTO;

class CreateUserDTO extends BaseDTO
{
    public string $name;
    public string $email;
    public string $password;

    public function __construct(string $name, string $email, string $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ];
    }
    
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password) //irá fazer a criptografia da senha diretamente no DTO
        ];
    }
}