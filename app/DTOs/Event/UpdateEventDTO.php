<?php

namespace App\DTOs\Event;

use App\DTOs\BaseDTO;

class UpdateEventDTO extends BaseDTO
{
    public ?string $description;
    public ?string $date;
    public ?int $capacity;
    public ?int $quantity_stages;
    public ?string $status;

    public function __construct(
        ?string $description = null,
        ?string $date = null,
        ?int $capacity = null,
        ?int $quantity_stages = null,
        ?string $status = null
    ) {
        $this->description = $description;
        $this->date = $date;
        $this->capacity = $capacity;
        $this->quantity_stages = $quantity_stages;
        $this->status = $status;
    }

    public function rules(): array
    {
        return [
            'description' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'capacity' => 'sometimes|integer|min:1',
            'quantity_stages' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:active,inactive'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'description' => $this->description,
            'date' => $this->date,
            'capacity' => $this->capacity,
            'quantity_stages' => $this->quantity_stages,
            'status' => $this->status
        ], fn($value) => !is_null($value));
    }
}
