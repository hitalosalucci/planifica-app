<?php

namespace App\Services\CoffeeRoom;

use App\DTOs\CoffeeRoom\CreateCoffeeRoomDTO;
use App\Models\CoffeeRoom\CoffeeRoomModel;
use App\Repositories\CoffeeRoom\CoffeeRoomRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<CoffeeRoomModel, CreateCoffeeRoomDTO>
 */
class CoffeeRoomService extends BaseService
{
    public function __construct(CoffeeRoomRepository $repository)
    {
        parent::__construct($repository);
    }
}
