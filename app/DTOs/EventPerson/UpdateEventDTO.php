<?php

namespace App\DTOs\EventPerson;

use App\DTOs\BaseDTO;

class UpdateEventPersonDTO extends BaseDTO
{
    public ?string $entry_code;
    public ?string $status;

    public function __construct(?string $entry_code = null, ?string $status = null)
    {
        $this->entry_code = $entry_code;
        $this->status = $status;
    }

    public function rules(): array
    {
        return [
            'entry_code' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive'
        ];
    }

    public function toArray(): array
    {
        return array_filter([
            'entry_code' => $this->entry_code,
            'status' => $this->status
        ]);
    }
}
