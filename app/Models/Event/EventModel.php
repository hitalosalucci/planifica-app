<?php

namespace App\Models\Event;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\BaseModel;
use App\Models\EventPerson\EventPersonModel;
use App\Models\Person\PersonModel;
use App\Models\Room\RoomModel;

class EventModel extends BaseModel
{
    protected $table = 'events';

    protected $fillable = [
        'description',
        'date',
        'capacity',
        'quantity_stages',
				'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => StatusEnum::class
    ];

    protected $attributes = [
        'quantity_stages' => 2 //Valor default de estágios, caso não informado
    ];

    public function people()
    {
        return $this->belongsToMany(PersonModel::class, 'events_people', 'event_id', 'person_id')
            ->using(EventPersonModel::class)
            ->withPivot('entry_code', 'status')
            ->withTimestamps();
    }
}