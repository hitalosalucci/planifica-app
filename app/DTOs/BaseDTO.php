<?php

namespace App\DTOs;

use ReflectionClass;
use ReflectionProperty;
use ReflectionNamedType;
use ReflectionUnionType;
use Illuminate\Http\Request;

abstract class BaseDTO
{

  abstract public function rules(): array;
  
  public function validate(): void
  {
    validator($this->toArray(), $this->rules())->validate();
  }

  public function toArray(): array
  {
    $properties = [];
    $reflection = new ReflectionClass($this);
    
    foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
      $name = $property->getName();
      $properties[$name] = $this->{$name};
    }
    
    return $properties;
  }
  
  public static function fromArray(array $data): static
  {
    $dto = new static();
    $reflection = new ReflectionClass($dto);
    
    foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
      $name = $property->getName();
      if (array_key_exists($name, $data)) {
          $dto->{$name} = $data[$name];
      }
    }
    
    return $dto;
  }

  /**
   * Cria uma instância do DTO com base nos dados do request,
   * convertendo para os tipos esperados automaticamente.
   */
  public static function fromRequest(Request $request): static
  {
      $reflection = new ReflectionClass(static::class);
      $constructor = $reflection->getConstructor();
      $params = $constructor?->getParameters() ?? [];

      $args = [];

      foreach ($params as $param) {
          $name = $param->getName();
          $value = $request->input($name);

          // Se não foi passado no request e existe valor padrão, usa ele
          if (is_null($value) && $param->isDefaultValueAvailable()) {
              $value = $param->getDefaultValue();
              $args[] = $value;
              continue;
          }

          // Identifica o tipo esperado
          $type = $param->getType();

          if ($type instanceof ReflectionNamedType) {
              $expectedType = $type->getName();

              // Conversão simples por tipo
              $value = self::castToType($value, $expectedType);
          }

          $args[] = $value;
      }

      return new static(...$args);
  }

  /**
   * Faz a conversão básica do valor para o tipo esperado
   */
  protected static function castToType($value, string $type)
  {
      if (is_null($value)) return null;

      return match ($type) {
          'int'     => (int) $value,
          'float'   => (float) $value,
          'bool'    => filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
          'string'  => (string) $value,
          default   => $value, // caso de array, objeto, etc.
      };
  }
}