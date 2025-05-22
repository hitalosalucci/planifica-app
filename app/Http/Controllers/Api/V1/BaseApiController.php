<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\BaseService;

abstract class BaseApiController
{
    protected BaseService $service;

    abstract protected function getService(): BaseService;

    public function __construct($service)
    {
        $this->service = $service;
    }

    /**
     * Retorna todos os registros
     */
    public function getAll(): JsonResponse
    {
        $data = $this->service->getAll();
        return response()->json($data);
    }

    /**
     * Retorna um registro pelo ID
     */
    public function getById(int $id): JsonResponse
    {
        $data = $this->service->getById($id);
        if (!$data) {
            return $this->errorResponse('Registro não encontrado', Response::HTTP_NOT_FOUND);
        }
        return $this->successResponse($data);
    }

    public function getAllPaginated(int | null $perPage = null, int | null $page = null): JsonResponse
    {
        $data = $this->service->getAllPaginated($perPage, $page);
        return response()->json($data);
    }

    /**
     * Cria um novo registro
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $dtoClass = $this->getCreateDTO();
            
            $constructor = (new \ReflectionClass($dtoClass))->getConstructor();
            $params = $constructor?->getParameters() ?? [];

            // Extrai os valores do request na ordem correta
            $args = collect($params)
                ->map(function ($param) use ($request) {
                    $key = $param->getName();
                    return $request->input($key, $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
                })
                ->all();

            $dto = new $dtoClass(...$args);

            $data = $this->service->create($dto);
            return $this->successResponse($data, Response::HTTP_CREATED, 'Registro criado com sucesso');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Error: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Atualiza o registro
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $dtoClass = $this->getUpdateDTO();
            $constructor = (new \ReflectionClass($dtoClass))->getConstructor();
            $params = $constructor?->getParameters() ?? [];

            // Extrai os valores do request na ordem correta
            $args = collect($params)
                ->map(function ($param) use ($request) {
                    $key = $param->getName();
                    return $request->input($key, $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null);
                })
                ->all();

            $dto = new $dtoClass(...$args);

            $data = $this->service->update($id, $dto);
            return $this->successResponse($data, Response::HTTP_OK, 'Registro atualizado com sucesso');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY, $e->errors());
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Error: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deleta o registro
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->errorResponse('Internal Error: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function successResponse(
        mixed $data = null,
        int $statusCode = Response::HTTP_OK,
        string $message = 'Operação realizada com sucesso'
    ): JsonResponse {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    protected function errorResponse(
        string $message,
        int $statusCode = Response::HTTP_BAD_REQUEST,
        array $errors = []
    ): JsonResponse {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }

    protected function getCreateDTO(): string
    {
        throw new \LogicException('Você precisa sobrescrever getCreateDTO()');
    }

    protected function getUpdateDTO(): string
    {
        throw new \LogicException('Você precisa sobrescrever getUpdateDTO()');
    }
}
