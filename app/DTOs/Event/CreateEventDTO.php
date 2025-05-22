<?php

namespace App\DTOs\Event;

use App\DTOs\BaseDTO;

class CreateEventDTO extends BaseDTO
{
    public string $description;
    public string $date;
    public int $capacity;
    public ?int $quantity_stages;

    public function __construct(string $description, string $date, int $capacity, ?int $quantity_stages = 2)
    {
        $this->description = $description;
        $this->date = $date;
        $this->capacity = $capacity;
        $this->quantity_stages = $quantity_stages ?? 2;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'capacity' => 'required|integer|min:1',
            'quantity_stages' => 'nullable|integer|min:1'
        ];
    }

    public function toArray(): array
    {
        return [
            'description' => $this->description,
            'date' => $this->date,
            'capacity' => $this->capacity,
            'quantity_stages' => $this->quantity_stages
        ];
    }
}
