<?php

namespace Storytile\JsonStructure;

class JsonStructure implements \JsonSerializable
{
    protected bool $convertCamelToSnakeCase = true;

    public static function fromJson(array|string $data): static {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        $class = new static();
        $class->fillFromJson($data);
        return $class;
    }

    public function toArray(): array {
        $result = [];
        foreach (get_class_vars(static::class) as $property => $defaultValue) {
            $propertyType = new \ReflectionProperty(static::class, $property);
            if (!$propertyType->isPublic()) {
                continue;
            }
            $key = $this->convertCamelToSnakeCase ? $this->camelToSnakeCase($property) : $property;
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

    protected function fillFromJson(array $data) {
        foreach (get_class_vars(static::class) as $property => $defaultValue) {
            $jsonKey = $this->convertCamelToSnakeCase ? $this->camelToSnakeCase($property) : $property;
            if (array_key_exists($jsonKey, $data)) {
                if (is_array($data[$jsonKey])) {
                    // check if the class property is of a type that inherits JsonStructure:
                    // -> if no, directly assign the JSON value
                    // -> if yes, assign a new JsonStructure based on the property's type
                    $propertyType = new \ReflectionProperty(static::class, $property);
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
            }
        }
    }

    protected function camelToSnakeCase($value) {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $value)), '_');
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}