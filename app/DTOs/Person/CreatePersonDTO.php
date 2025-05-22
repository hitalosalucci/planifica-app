<?php

namespace App\DTOs\Person;

use App\DTOs\BaseDTO;

class CreatePersonDTO extends BaseDTO
{
    public string $name;
    public string $cpf;
    public ?string $birth_date;
    public ?string $phone;
    public ?string $email;
    public ?string $gender;

    public function __construct(
        string $name,
        string $cpf,
        ?string $birth_date = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $gender = null
    ) {
        $this->name = $name;
        $this->cpf = $cpf;
        $this->birth_date = $birth_date;
        $this->phone = $phone;
        $this->email = $email;
        $this->gender = $gender;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|size:11',
            'birth_date' => 'sometimes|nullable|date',
            'phone' => 'sometimes|nullable|string|max:14',
            'email' => 'sometimes|nullable|email|max:255',
            'gender' => 'sometimes|nullable|in:male,female,non_binary,other,prefer_not_say'
        ];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender
        ];
    }
}
