<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\DTOs\Event\CreateEventDTO;
use App\DTOs\Event\UpdateEventDTO;
use App\Services\Event\EventService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class EventController extends BaseApiController
{
    public function __construct(EventService $eventService)
    {
        parent::__construct($eventService);
    }

    protected function getService(): EventService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateEventDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateEventDTO::class;
    }

}
