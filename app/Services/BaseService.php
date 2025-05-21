<?php

namespace App\Services;

use App\DTOs\BaseDTO;
use App\Models\BaseModel;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseService
{
    /**
     * @var BaseRepository
     */
    protected $repository;

    /**
     * BaseService constructor
     *
     * @param BaseRepository $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * coletar todos os dados
     *
     * @param array $columns
     * @return Collection
     */
    public function getAll(array $columns = ['*']): Collection
    {
        return $this->repository->all($columns);
    }

    /**
     * Coletar dados com paginação
     *
     * @param int $perPage
     * @param array $columns
     * @return Collection
     */
    public function getPaginated(int $perPage = 15, array $columns = ['*']): Collection
    {
        return $this->repository->paginate($perPage, $columns);
    }

    /**
     * coletar pelo id
     *
     * @param int $id
     * @param array $columns
     * @return BaseModel|null
     */
    public function getById(int $id, array $columns = ['*']): ?BaseModel
    {
        return $this->repository->find($id, $columns);
    }

    /**
     * Create a new record
     *
     * @param BaseDTO $dto
     * @return BaseModel
     */
    public function create(BaseDTO $dto): BaseModel
    {
        return $this->repository->create($dto->toArray());
    }

    /**
     * Atualizar dado
     *
     * @param int $id
     * @param BaseDTO $dto
     * @return BaseModel
     */
    public function update(int $id, BaseDTO $dto): BaseModel
    {
        return $this->repository->update($id, $dto->toArray());
    }

    /**
     * Apagar dado
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}