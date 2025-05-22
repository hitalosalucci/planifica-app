<?php

namespace App\Http\Controllers\Api\V1\User;

use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

class UserController extends BaseApiController
{
    public function __construct(UserService $userService)
    {
        parent::__construct($userService);
    }

    protected function getService(): UserService
    {
      return $this->service;
    }

    protected function getCreateDTO(): string
    {
        return CreateUserDTO::class;
    }
    
    protected function getUpdateDTO(): string
    {
        return UpdateUserDTO::class;
    }

}
