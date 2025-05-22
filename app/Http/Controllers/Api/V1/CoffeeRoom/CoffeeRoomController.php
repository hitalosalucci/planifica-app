<?php

namespace App\Http\Controllers\Api\V1\CoffeeRoom;

use App\DTOs\CoffeeRoom\CreateCoffeeRoomDTO;
use App\DTOs\CoffeeRoom\UpdateCoffeeRoomDTO;
use App\Services\CoffeeRoom\CoffeeRoomService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class CoffeeRoomController extends BaseApiController
{
    public function __construct(CoffeeRoomService $coffeeRoomService)
    {
        parent::__construct($coffeeRoomService);
    }

    protected function getService(): CoffeeRoomService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateCoffeeRoomDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateCoffeeRoomDTO::class;
    }

}
