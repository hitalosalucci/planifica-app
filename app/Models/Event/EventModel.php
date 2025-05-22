<?php

namespace App\Models\Event;

use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\BaseModel;

class EventModel extends BaseModel
{
    protected $table = 'events';

    protected $fillable = [
        'description',
        'date',
        'capacity',
        'quantity_stages'
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => RoomStatusEnum::class
    ];

    protected $attributes = [
        'quantity_stages' => 2 //Valor default de estágios, caso não informado
    ];

//     public function people()
//     {
//         return $this->belongsToMany(Person::class, 'event_person')
//           ->withPivot('entry_code', 'status')
//           ->withTimestamps();
// }

//     public function rooms()
//     {
//         return $this->belongsToMany(Room::class, 'event_person_stage', 'event_id', 'coffee_room_id')
//           ->withPivot('stage', 'status')
//           ->withTimestamps();
//     }
}