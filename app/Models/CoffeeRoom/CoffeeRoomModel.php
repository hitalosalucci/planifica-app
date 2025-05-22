<?php

namespace App\Models\CoffeeRoom;

use App\Enums\RoomStatusEnum;
use App\Models\BaseModel;

class CoffeeRoomModel extends BaseModel
{
    protected $table = 'coffee_rooms';

    protected $fillable = [
        'name',
        'capacity',
        'status',
        'description'
    ];

    protected $casts = [
        'status' => RoomStatusEnum::class
    ];
}