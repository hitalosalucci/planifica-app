<?php

namespace App\Repositories\Room;

use App\Models\Room\RoomModel;
use App\Repositories\BaseRepository;

class RoomRepository extends BaseRepository
{
    public function __construct(RoomModel $model)
    {
        parent::__construct($model);
    }
}
