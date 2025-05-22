<?php

namespace App\DTOs\Event;

use App\DTOs\BaseDTO;

class CreateEventPersonDTO extends BaseDTO
{
    public int $event_id;
    public int $person_id;
    public ?string $entry_code;

    public function __construct(int $event_id, int $person_id, ?string $entry_code = null)
    {
        $this->event_id = $event_id;
        $this->person_id = $person_id;
        $this->entry_code = $entry_code;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'person_id' => 'required|exists:people,id',
            'entry_code' => 'nullable|string|max:80',
        ];
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->event_id,
            'person_id' => $this->person_id,
            'entry_code' => $this->entry_code,
        ];
    }
}

