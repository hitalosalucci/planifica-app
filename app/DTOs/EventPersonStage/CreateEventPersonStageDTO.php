<?php

namespace App\DTOs\EventPersonStage;

use App\DTOs\BaseDTO;

class CreateEventPersonStageDTO extends BaseDTO
{
    public int $event_person_id;
    public int $coffee_room_id;
    public int $stage;

    public function __construct(int $event_person_id, int $coffee_room_id, int $stage)
    {
        $this->event_person_id = $event_person_id;
        $this->coffee_room_id = $coffee_room_id;
        $this->stage = $stage;
    }

    public function rules(): array
    {
        return [
            'event_person_id' => 'required|exists:events_people,id',
            'coffee_room_id' => 'required|exists:coffee_rooms,id',
            'stage' => 'required|integer|min:1'
        ];
    }

    public function toArray(): array
    {
        return [
            'event_person_id' => $this->event_person_id,
            'coffee_room_id' => $this->coffee_room_id,
            'stage' => $this->stage
        ];
    }
}
