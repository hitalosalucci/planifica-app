<?php

namespace App\DTOs\Person;

use App\DTOs\BaseDTO;

class UpdatePersonDTO extends BaseDTO
{
    public ?string $name;
    public ?string $cpf;
    public ?string $birth_date;
    public ?string $phone;
    public ?string $email;
    public ?string $gender;
    public ?string $status;

    public function __construct(
        ?string $name = null,
        ?string $cpf = null,
        ?string $birth_date = null,
        ?string $phone = null,
        ?string $email = null,
        ?string $gender = null,
        ?string $status = null
    ) {
        $this->name = $name;
        $this->cpf = $cpf;
        $this->birth_date = $birth_date;
        $this->phone = $phone;
        $this->email = $email;
        $this->gender = $gender;
        $this->status = $status;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'cpf' => 'sometimes|string|size:11',
            'birth_date' => 'sometimes|date',
            'phone' => 'sometimes|string|max:14',
            'email' => 'sometimes|email|max:255',
            'gender' => 'sometimes|in:male,female,non_binary,other,prefer_not_say',
            'status' => 'sometimes|in:active,inactive'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'cpf' => $this->cpf,
            'birth_date' => $this->birth_date,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
