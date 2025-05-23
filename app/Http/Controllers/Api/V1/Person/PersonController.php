<?php

namespace App\Http\Controllers\Api\V1\Person;

use App\DTOs\Person\CreatePersonDTO;
use App\DTOs\Person\UpdatePersonDTO;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;
use Illuminate\Http\JsonResponse;

class PersonController extends BaseApiController
{
    public function __construct(PersonService $personService)
    {
        parent::__construct($personService);
    }

    protected function getService(): PersonService
    {
        return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreatePersonDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdatePersonDTO::class;
    }

    /**
     * Retorna a lista de todas os eventos do pessoa
     *
     * @param int $person
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventsByPeople(int $person): JsonResponse
    {
        /** @var PersonService $service */
        $service = $this->service;

        $people = $service->getEventsByPeople($person);

        return response()->json($people);
    }

}
