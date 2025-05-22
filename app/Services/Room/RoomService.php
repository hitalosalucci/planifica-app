<?php

namespace App\Services\Room;

use App\DTOs\Room\CreateRoomDTO;
use App\Models\Room\RoomModel;
use App\Repositories\Room\RoomRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<RoomModel, CreateRoomDTO>
 */
class RoomService extends BaseService
{
    public function __construct(RoomRepository $repository)
    {
        parent::__construct($repository);
    }
}
