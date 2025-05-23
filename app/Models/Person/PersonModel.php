<?php

namespace App\Models\Person;

use App\Enums\PersonGenderEnum;
use App\Enums\StatusEnum;
use App\Models\BaseModel;
use App\Models\Event\EventModel;
use App\Models\EventPerson\EventPersonModel;

class PersonModel extends BaseModel
{
    protected $table = 'people';

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'phone',
        'email',
        'gender',
        'status'
    ];

    protected $casts = [
        'gender' => PersonGenderEnum::class,
        'status' => StatusEnum::class,
        'birth_date' => 'date'
    ];

    public function events()
    {
        return $this->belongsToMany(EventModel::class, 'events_people', 'person_id', 'event_id')
            ->using(EventPersonModel::class)
            ->withPivot('entry_code', 'status')
            ->withTimestamps();
    }
}