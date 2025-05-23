<?php

namespace App\Services\Person;

use App\DTOs\Person\CreatePersonDTO;
use App\Models\Person\PersonModel;
use App\Repositories\Person\PersonRepository;
use App\Services\BaseService;

/**
 * @extends BaseService<PersonModel, CreatePersonDTO>
 */
class PersonService extends BaseService
{
    public function __construct(PersonRepository $repository)
    {
        parent::__construct($repository);
    }

    /* Retorna a lista de todas os eventos do pessoa
    *
    * @param int $person
    * @return \Illuminate\Http\JsonResponse
    */
    public function getEventsByPeople(int $personId): array
    {
        /** @var PersonRepository $repository */
        $repository = $this->repository;

        return $repository->getEventsByPeople($personId);
    }
}
