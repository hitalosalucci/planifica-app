<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;

/**
 * @template TModel of Model
 */
abstract class BaseRepository
{
    /**
     * @var TModel
     */
    protected $model;

    /**
     * @param Model $model
     * BaseRepository constructor.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Retornar todos os dados
     * 
     * @param array $columns
     * @param array $relations
     * @return Collection<int, TModel>
     */
    public function getAll(array $columns = ['*'], array $relations = []): Collection
    {
      $query = $this->model->with($relations);

      // Verifica se a tabela tem a coluna "created_at"
      if (Schema::hasColumn($this->model->getTable(), 'created_at')) {
          $query->orderByDesc('created_at');
      }
  
      return $query->get($columns);
    }

    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function getAllPaginated(int $perPage = 15, int $page = 1, array $columns = ['*'], string $orderBy = 'id', string $orderDirection = 'asc', array $relations = []): LengthAwarePaginator
    {

      Paginator::currentPageResolver(fn() => $page);

      $query = $this->model->with($relations);

      if ($orderBy === 'id' && Schema::hasColumn($this->model->getTable(), 'created_at')) {
        $query->orderByDesc('created_at');
      } else {
        $query->orderBy($orderBy, $orderDirection);
      }

      return $query->with($relations)->paginate($perPage, $columns);
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
      $model = $this->model
        ->with($relations)
        ->select($columns)
        ->find($id);

      return $model?->append($appends);
    }

    /**
     * Retornar um dado passando a coluna
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return TModel|null
     */
    public function getByField(string $field, mixed $value, array $columns = ['*'], array $relations = [], array $appends = []): ?Model
    {
        $model = $this->model
          ->with($relations)
          ->where($field, $value)
          ->select($columns)
          ->first();

        return $model?->append($appends);
    }

    /**
     * Criar um dado
     *
     * @param array<string, mixed> $data
     * @return TModel
     */
    public function create(array $data): Model
    {
      return $this->model->create($data);
    }

    /**
     * Atualizar um dado
     *
     * @param int $id
     *  @param array<string, mixed> $data
     * @return TModel
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->getById($id);
        $record->update($data);

        return $record;
    }

    /**
     * Deletar um dado
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model->destroy($id);
    }
}