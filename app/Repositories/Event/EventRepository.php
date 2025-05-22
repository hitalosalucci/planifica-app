<?php

namespace App\Repositories\Event;

use App\Models\Event\EventModel;
use App\Repositories\BaseRepository;

class EventRepository extends BaseRepository
{
    public function __construct(EventModel $model)
    {
        parent::__construct($model);
    }
}
