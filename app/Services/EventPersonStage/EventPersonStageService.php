<?php

namespace App\Services\EventPerson;

use App\DTOs\EventPerson\CreateEventPersonDTO;
use App\Models\EventPerson\EventPersonModel;
use App\Repositories\EventPerson\EventPersonRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<EventPersonModel, CreateEventPersonDTO>
 */
class EventPersonService extends BaseService
{
    public function __construct(EventPersonRepository $repository)
    {
        parent::__construct($repository);
    }
}
