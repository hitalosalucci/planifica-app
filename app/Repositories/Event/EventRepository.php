<?php

namespace App\Repositories\Event;

use App\Models\Event\EventModel;
use App\Repositories\BaseRepository;

/**
 * @extends BaseRepository<EventModel>
 */
class EventRepository extends BaseRepository
{
    public function __construct(EventModel $model)
    {
        parent::__construct($model);
    }

    /**
     * Vincula uma pessoa a um evento
     * 
     * @param int $eventId ID do evento
     * @param int $personId ID da pessoa
     * @param string|null $entryCode Código de entrada (opcional)
     * @return void
     */
    public function attachPerson(int $eventId, int $personId, ?string $entryCode = null)
    {
        $event = $this->getById($eventId);

        $event->people()->attach($personId, ['entry_code' => $entryCode]);
    }

    /**
     * Remove o vínculo de uma pessoa com um evento
     * 
     * @param int $eventId ID do evento
     * @param int $personId ID da pessoa
     * @return void
     */
    public function detachPerson(int $eventId, int $personId)
    {
        $event = $this->getById($eventId);
        
        if (!$event->people()->where('person_id', $personId)->exists()) {
            throw new \Exception('Esta pessoa não está vinculada ao evento');
        }
        
        $event->people()->detach($personId);
    }

    /**
     * Retorna lista das pessoas no evento
     *
     * @param int $eventId
     * @return array
     */
    public function getPeopleByEvent(int $eventId): array
    {
        $event = $this->model->with(['people' => function($query) {
            $query->wherePivotNull('deleted_at'); // filtra apenas pivots não deletados
        }])->find($eventId);

        if (!$event) {
            throw new \Exception("Evento não encontrado.");
        }

        return $event->people->toArray();
    }

}
