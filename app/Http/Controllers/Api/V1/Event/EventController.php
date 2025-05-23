<?php

namespace App\Http\Controllers\Api\V1\Event;

use App\DTOs\Event\CreateEventDTO;
use App\DTOs\Event\UpdateEventDTO;
use App\DTOs\EventPerson\CreateEventPersonDTO;
use App\DTOs\EventPerson\DetachEventPersonDTO;
use App\Services\Event\EventService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;
use Illuminate\Http\JsonResponse;

class EventController extends BaseApiController
{
    public function __construct(EventService $eventService)
    {
        parent::__construct($eventService);
    }

    protected function getService(): EventService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateEventDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateEventDTO::class;
    }

    /**
     * Vincula uma pessoa a um evento.
     *
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachPerson(Request $request, int $event): JsonResponse
    {
        // Validação e criação do DTO
        $dto = new CreateEventPersonDTO(
            event_id: $event,
            person_id: $request->input('person_id'),
            entry_code: $request->input('entry_code', null)
        );

        /** @var EventService $service */
        $service = $this->service;

        $service->attachPerson($dto);

        return response()->json([
            'message' => 'Pessoa vinculada ao evento com sucesso'
        ], 201);
    }

    /**
     * Desvincula uma pessoa a um evento
     *
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function detachPerson(int $event, int $person): JsonResponse
    {
        // Validação e criação do DTO
        $dto = new DetachEventPersonDTO(
            event_id: $event,
            person_id: $person,
        );

        /** @var EventService $service */
        $service = $this->service;

        $service->detachPerson($dto);

        return response()->json([
            'message' => 'Pessoa desvinculada ao evento com sucesso'
        ], 201);
    }

    /**
     * Retorna a lista de todas as pessoas no evento
     *
     * @param Request $request
     * @param int $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPeople(int $event): JsonResponse
    {
        /** @var EventService $service */
        $service = $this->service;

        $people = $service->getPeopleByEvent($event);

        return response()->json($people);
    }

}
