<?php

namespace App\Models\Room;

use App\Enums\RoomStatusEnum;
use App\Models\BaseModel;

class RoomModel extends BaseModel
{
    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'capacity',
        'status',
        'description'
    ];

    protected $casts = [
        'status' => RoomStatusEnum::class
    ];

    // public function events()
    // {
    //     return $this->belongsToMany(Event::class, 'event_person_stage', 'coffee_room_id', 'event_id')
    //       ->withPivot('stage', 'status')
    //       ->withTimestamps();
    // }
}