<?php

namespace App\Http\Controllers\Api\V1\EventPersonStage;

use App\DTOs\EventPersonStage\CreateEventPersonStageDTO;
use App\DTOs\EventPersonStage\UpdateEventPersonStageDTO;
use App\Services\EventPersonStage\EventPersonStageService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class EventPersonStageController extends BaseApiController
{
    public function __construct(EventPersonStageService $eventPersonStageService)
    {
        parent::__construct($eventPersonStageService);
    }

    protected function getService(): EventPersonStageService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateEventPersonStageDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateEventPersonStageDTO::class;
    }

}
