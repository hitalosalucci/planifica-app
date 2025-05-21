<?php

namespace App\DTOs;

use ReflectionClass;
use ReflectionProperty;

abstract class BaseDTO
{

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
}