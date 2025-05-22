<?php

namespace App\Repositories\EventPerson;

use App\Models\EventPerson\EventPersonModel;
use App\Repositories\BaseRepository;

class EventPersonRepository extends BaseRepository
{
    public function __construct(EventPersonModel $model)
    {
        parent::__construct($model);
    }
}
