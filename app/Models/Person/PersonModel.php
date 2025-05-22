<?php

namespace App\Models\Person;

use App\Enums\PersonGenderEnum;
use App\Enums\RoomStatusEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\BaseModel;
use App\Models\Event\EventModel;

class PersonModel extends BaseModel
{
    protected $table = 'people';

    protected $fillable = [
        'name',
        'cpf',
        'birth_date',
        'phone',
        'email',
        'gender'
    ];

    protected $casts = [
        'gender' => PersonGenderEnum::class,
        'status' => RoomStatusEnum::class,
        'birth_date' => 'date'
    ];

    public function events()
    {
        return $this->belongsToMany(EventModel::class, 'event_person')
            ->withPivot('entry_code', 'status')
            ->withTimestamps();
    }
}