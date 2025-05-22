<?php

namespace App\Models\EventPerson;

use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventPersonModel extends Pivot
{
    protected $table = 'events_people';

    protected $casts = [
        'status' => RoomStatusEnum::class
    ];

    // public function event()
    // {
    //     return $this->belongsTo(EventModel::class);
    // }

    // public function person()
    // {
    //     return $this->belongsTo(PersonModel::class);
    // }

    // public function stages()
    // {
    //     return $this->hasMany(EventPersonStage::class, 'event_person_id');
    // }
}