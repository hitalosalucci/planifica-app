<?php

namespace App\Repositories\CoffeeRoom;

use App\Models\CoffeeRoom\CoffeeRoomModel;
use App\Repositories\BaseRepository;

class CoffeeRoomRepository extends BaseRepository
{
    public function __construct(CoffeeRoomModel $model)
    {
        parent::__construct($model);
    }
}
