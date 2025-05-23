<?php

namespace App\Repositories\Person;

use App\Models\Person\PersonModel;
use App\Repositories\BaseRepository;

class PersonRepository extends BaseRepository
{
    public function __construct(PersonModel $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?PersonModel
    {
      return $this->model->where('email', $email)->first();
    }

    /**
     * Retorna lista das eventos da pessoa
     *
     * @param int $personId
     * @return array
     */
    public function getEventsByPeople(int $personId): array
    {
        $person = $this->model->with(['events' => function($query) {
            $query->wherePivotNull('deleted_at'); // filtra apenas pivots não deletados
        }])->find($personId);

        if (!$person) {
            throw new \Exception("Pessoa não encontrada");
        }

        return $person->events->toArray();
    }
}
