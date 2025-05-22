<?php

namespace App\Services\Event;

use App\DTOs\Event\CreateEventDTO;
use App\Models\Event\EventModel;
use App\Repositories\Event\EventRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<EventModel, CreateEventDTO>
 */
class EventService extends BaseService
{
    public function __construct(EventRepository $repository)
    {
        parent::__construct($repository);
    }
}
