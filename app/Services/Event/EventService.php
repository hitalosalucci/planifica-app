<?php

namespace App\Services\Event;

use App\DTOs\Event\CreateEventDTO;
use App\DTOs\EventPerson\CreateEventPersonDTO;
use App\DTOs\EventPerson\DetachEventPersonDTO;
use App\Models\Event\EventModel;
use App\Repositories\Event\EventRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<EventModel, EventRepository>
 */
class EventService extends BaseService
{

    public function __construct(EventRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Vincula uma pessoa a um evento.
     *
     * @param CreateEventPersonDTO $dto
     * @return void
     */
    public function attachPerson(CreateEventPersonDTO $dto)
    {  

        /** @var EventRepository $repository */
        $repository = $this->repository;
        
        $repository->attachPerson($dto->event_id, $dto->person_id, $dto->entry_code);
    }

    /**
     * Remove o vínculo de uma pessoa com um evento
     *
     * @param DetachEventPersonDTO $dto
     * @return void
     */
    public function detachPerson(DetachEventPersonDTO $dto)
    {
        /** @var EventRepository $repository */
        $repository = $this->repository;
        
        $repository->detachPerson($dto->event_id, $dto->person_id);
    }

    /**
     * Retorna lista das pessoas no evento
     *
     * @param int $eventId
     * @return array
     */
    public function getPeopleByEvent(int $eventId): array
    {   
        /** @var EventRepository $repository */
        $repository = $this->repository;

        return $repository->getPeopleByEvent($eventId);
    }
}
