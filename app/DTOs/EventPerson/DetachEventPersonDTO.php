<?php

namespace App\DTOs\EventPerson;

use App\DTOs\BaseDTO;

class DetachEventPersonDTO extends BaseDTO
{
    public int $event_id;
    public int $person_id;

    public function __construct(int $event_id, int $person_id, ?string $entry_code = null)
    {
        $this->event_id = $event_id;
        $this->person_id = $person_id;
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'person_id' => 'required|exists:people,id',
        ];
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->event_id,
            'person_id' => $this->person_id,
        ];
    }
}

