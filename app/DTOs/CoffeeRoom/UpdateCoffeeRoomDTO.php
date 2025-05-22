<?php

namespace App\DTOs\CoffeeRoom;

use App\DTOs\BaseDTO;

class UpdateCoffeeRoomDTO extends BaseDTO
{
    public ?string $name;
    public ?int $capacity;
    public ?string $description;
    public ?string $status;

    public function __construct(
        ?string $name = null,
        ?int $capacity = null,
        ?string $description = null,
        ?string $status = null
    ) {
        $this->name = $name;
        $this->capacity = $capacity;
        $this->description = $description;
        $this->status = $status;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
            'description' => 'sometimes|string',
            'status' => 'sometimes|in:active,inactive'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'capacity' => $this->capacity,
            'description' => $this->description,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
