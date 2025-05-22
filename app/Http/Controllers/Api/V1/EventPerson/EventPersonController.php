<?php

namespace App\Http\Controllers\Api\V1\EventPerson;

use App\DTOs\EventPerson\CreateEventPersonDTO;
use App\DTOs\EventPerson\UpdateEventPersonDTO;
use App\Services\EventPerson\EventPersonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class EventPersonController extends BaseApiController
{
    public function __construct(EventPersonService $eventPersonService)
    {
        parent::__construct($eventPersonService);
    }

    protected function getService(): EventPersonService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateEventPersonDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateEventPersonDTO::class;
    }

}
