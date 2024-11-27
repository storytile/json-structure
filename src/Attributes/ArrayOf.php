<?php

namespace Storytile\JsonStructure\Attributes;

#[\Attribute]
class ArrayOf
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }
    public function getType(): string
    {
        return $this->type;
    }
}