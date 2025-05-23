<?php

namespace App\Models\EventPerson;

use App\Enums\StatusEnum;
use App\Models\BaseModelPivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventPersonModel extends BaseModelPivot
{
    protected $table = 'events_people';

    protected $casts = [
        'status' => StatusEnum::class
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