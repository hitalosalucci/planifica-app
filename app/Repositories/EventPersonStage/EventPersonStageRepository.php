<?php

namespace App\Repositories\EventPersonStage;

use App\Models\EventPersonStage\EventPersonStageModel;
use App\Repositories\BaseRepository;

class EventPersonStageRepository extends BaseRepository
{
    public function __construct(EventPersonStageModel $model)
    {
        parent::__construct($model);
    }
}
