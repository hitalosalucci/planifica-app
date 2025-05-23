<?php

namespace App\Models\EventPersonStage;

use App\Enums\StatusEnum;
use App\Models\BaseModelPivot;
use App\Models\EventPerson\EventPersonModel;
use App\Models\CoffeeRoom\CoffeeRoomModel;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPersonStageModel extends BaseModelPivot
{
    protected $table = 'event_people_stages';

    protected $casts = [
        'status' => StatusEnum::class
    ];

    public function eventPerson()
    {
        return $this->belongsTo(EventPersonModel::class, 'event_person_id');
    }

    public function coffeeRoom()
    {
        return $this->belongsTo(CoffeeRoomModel::class, 'coffee_room_id');
    }
}