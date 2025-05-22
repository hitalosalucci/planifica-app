<?php

namespace App\DTOs\Room;

use App\DTOs\BaseDTO;

class CreateRoomDTO extends BaseDTO
{
    public string $name;
    public int $capacity;
    public ?string $description;

    public function __construct(
        string $name,
        int $capacity,
        ?string $description = null
    ) {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->description = $description;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ];
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'capacity' => $this->capacity,
            'description' => $this->description
        ];
    }
}
