<?php

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * obter classe modelo
     *
     * @return string
     */
    abstract public function model(): string;

    /**
     * Criar instância da classe de Modelo
     *
     * @return void
     */
    public function makeModel(): void
    {
        $model = app($this->model());
        $this->model = $model;
    }

    /**
     * coletar todos os dados
     *
     * @param array $columns
     * @return Collection
     */
    public function getAll(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
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
        return $this->model->paginate($perPage, $columns);
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
        return $this->model->find($id, $columns);
    }

    /**
     * Retornar um dado passando a coluna
     *
     * @param string $field
     * @param mixed $value
     * @param array $columns
     * @return BaseModel|null
     */
    public function getByField(string $field, mixed $value, array $columns = ['*']): ?BaseModel
    {
        return $this->model->where($field, $value)->first($columns);
    }

    /**
     * Criar um dado
     *
     * @param array $data
     * @return BaseModel
     */
    public function create(array $data): BaseModel
    {
        return $this->model->create($data);
    }

    /**
     * Atualizar um dado
     *
     * @param int $id
     * @param array $data
     * @return BaseModel
     */
    public function update(int $id, array $data): BaseModel
    {
        $record = $this->find($id);
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