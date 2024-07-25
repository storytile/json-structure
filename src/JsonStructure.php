<?php

namespace Storytile\JsonStructure;

use Storytile\JsonStructure\Attributes\KebabCase;

class JsonStructure implements \JsonSerializable
{
    protected bool $convertCamelToSnakeCase = true;
    protected array $jsonStructureUnmappedData = [];

    public static function fromJson(array|string $data, bool $keepUnmappedKeys = true): static {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        $class = new static();
        $class->fillFromJson($data, $keepUnmappedKeys);
        return $class;
    }

    public function toArray(): array {
        $result = $this->jsonStructureUnmappedData;
        foreach (get_class_vars(static::class) as $property => $defaultValue) {
            $propertyType = new \ReflectionProperty(static::class, $property);
            if (!$propertyType->isPublic()) {
                continue;
            }
            $key = $this->caseConversion($property, $propertyType);
            if ($propertyType->hasType() &&
                !$propertyType->getType()->isBuiltin() &&
                is_subclass_of($propertyType->getType()->getName(), JsonStructure::class)) {
                $result[$key] = $this->{$property}->toArray();
            }else{
                $result[$key] = $this->{$property};
            }
        }
        return $result;
    }

    protected function fillFromJson(array $data, bool $keepUnmappedKeys) {
        foreach (get_class_vars(static::class) as $property => $defaultValue) {
            $propertyType = new \ReflectionProperty(static::class, $property);
            $jsonKey = $this->caseConversion($property, $propertyType);
            if (array_key_exists($jsonKey, $data)) {
                if (is_array($data[$jsonKey])) {
                    // check if the class property is of a type that inherits JsonStructure:
                    // -> if no, directly assign the JSON value
                    // -> if yes, assign a new JsonStructure based on the property's type
                    if ($propertyType->hasType() &&
                        !$propertyType->getType()->isBuiltin() &&
                        is_subclass_of($propertyType->getType()->getName(), JsonStructure::class)) {
                        $this->{$property} = $propertyType->getType()->getName()::fromJson($data[$jsonKey]);
                    }else{
                        $this->{$property} = $data[$jsonKey];
                    }
                }else{
                    $this->{$property} = $data[$jsonKey];
                }
                unset($data[$jsonKey]);
            }
        }

        if ($keepUnmappedKeys) {
            $this->jsonStructureUnmappedData = $data;
        }else{
            $this->jsonStructureUnmappedData = [];
        }
    }

    protected function caseConversion(int|string $value, \ReflectionProperty $reflectionProperty)
    {
        if ($this->convertCamelToSnakeCase) {
            $value = $this->camelToSnakeCase($value);
        }

        if (count($reflectionProperty->getAttributes(KebabCase::class)) > 0) {
            if (!$this->convertCamelToSnakeCase) {
                $value = $this->camelToSnakeCase($value);
            }
            $value = str_replace("_", "-", $value);
        }
        return $value;
    }

    protected function camelToSnakeCase($value) {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $value)), '_');
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}