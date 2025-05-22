<?php

namespace App\DTOs\EventPersonStage;

use App\DTOs\BaseDTO;

class UpdateEventPersonStageDTO extends BaseDTO
{
    public ?int $stage;
    public ?string $status;

    public function __construct(?int $stage = null, ?string $status = null)
    {
        $this->stage = $stage;
        $this->status = $status;
    }

    public function rules(): array
    {
        return [
            'stage' => 'nullable|integer|min:1',
            'status' => 'nullable|in:active,inactive'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'stage' => $this->stage,
            'status' => $this->status
        ]);
    }
}