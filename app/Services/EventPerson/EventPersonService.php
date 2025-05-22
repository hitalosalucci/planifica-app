<?php

namespace App\Services\EventPersonStage;

use App\DTOs\EventPersonStage\CreateEventPersonStageDTO;
use App\Models\EventPersonStage\EventPersonStageModel;
use App\Repositories\EventPersonStage\EventPersonStageRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<EventPersonStageModel, CreateEventPersonStageDTO>
 */
class EventPersonStageService extends BaseService
{
    public function __construct(EventPersonStageRepository $repository)
    {
        parent::__construct($repository);
    }
}
