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
}
