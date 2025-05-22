<?php

namespace App\Http\Controllers\Api\V1\Room;

use App\DTOs\Room\CreateRoomDTO;
use App\DTOs\Room\UpdateRoomDTO;
use App\Services\Room\RoomService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class RoomController extends BaseApiController
{
    public function __construct(RoomService $roomService)
    {
        parent::__construct($roomService);
    }

    protected function getService(): RoomService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateRoomDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateRoomDTO::class;
    }

}
