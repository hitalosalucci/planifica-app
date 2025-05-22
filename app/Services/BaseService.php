<?php

namespace App\Services;

use App\DTOs\BaseDTO;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 * @template TDTO of BaseDTO
 */
abstract class BaseService
{
    /**
     * @var BaseRepository<TModel>
     */
    protected BaseRepository $repository;

    /**
     * BaseService constructor
     *
     * @param BaseRepository<TModel> $repository
     */
    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * coletar todos os dados
     *
     * @param array $columns
     * @param array $relations
     * @return Collection<int, TModel>
     */
    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
        return $this->repository->getAll($columns, $relations);
    }

    /**
     * Coletar dados com paginação
     *
     * @param int $perPage
     * @param array $columns
    *  @return array
     */
    public function getAllPaginated(int $perPage = 15, int $page = 1, array $columns = ['*'], string $orderBy = 'id', string $orderDirection = 'asc', array $relations = []): array
    {
      $paginated = $this->repository->getAllPaginated(
          $perPage,
          $page,
          $columns,
          $orderBy,
          $orderDirection,
          $relations
      );

      return [
        "data" => $paginated->items(),
        "current_page" => $paginated->currentPage(),
        "per_page" => $paginated->perPage(),
        "total" => $paginated->total(),
        "last_page" => $paginated->lastPage(),
      ];
    }

    /**
     * coletar pelo id
     *
     * @param int $id
     * @param array $columns
     * @return TModel|null
     */
    public function getById(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
      return $this->repository->getById(
          $id,
          $columns,
          $relations,
          $appends
      );
    }

    /**
     * Retornar um dado passando a coluna
     *
     * @param int $id
     * @param array $columns
     * @return TModel|null
     */
    public function getByField(int $id, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
      return $this->repository->getByField(
          $id,
          $columns,
          $relations,
          $appends
      );
    }


    /**
     * Create a new record
     *
     * @param TDTO $dto
     * @return TModel
     */
    public function create(BaseDTO $dto): Model
    {
      //validação no DTO, caso inválido com o DTo não avançará e criará o registro inválido
      $dto->validate();

      return $this->repository->create($dto->toArray());
    }

    /**
     * Atualizar dado
     *
     * @param int $id
     * @param TDTO $dto
     * @return TModel
     */
    public function update(int $id, BaseDTO $dto): Model
    {
        //validação no DTO, caso inválido com o DTo não avançará e atualizará o registro inválido
        $dto->validate();

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