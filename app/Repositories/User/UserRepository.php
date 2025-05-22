<?php

namespace App\Repositories\User;

use App\Models\User\UserModel;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(UserModel $model)
    {
        parent::__construct($model);
    }

    public function findByEmail(string $email): ?UserModel
    {
      return $this->model->where('email', $email)->first();
    }
}
