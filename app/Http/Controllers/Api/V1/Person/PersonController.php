<?php

namespace App\Http\Controllers\Api\V1\Person;

use App\DTOs\Person\CreatePersonDTO;
use App\DTOs\Person\UpdatePersonDTO;
use App\Services\Person\PersonService;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseApiController;

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

}
