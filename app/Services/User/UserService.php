<?php

namespace App\Services\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User\UserModel;
use App\Repositories\User\UserRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends BaseService<UserModel, CreateUserDTO>
 */
class UserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}
