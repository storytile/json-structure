<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class CamelCaseSerializationTest extends TestCase
{
    public function testToArrayWithConversion() {
        $structure = new CamelCaseSerializationWithConversionStructure();
        $array = $structure->toArray();
        $this->assertEquals([
            "camel_name" => "John"
        ], $array);

        $structure->camelName = "Lightning";
        $array = $structure->toArray();
        $this->assertEquals([
            "camel_name" => "Lightning"
        ], $array);
    }

    public function testJsonEncodeWithConversion() {
        $encoded = json_encode(new CamelCaseSerializationWithConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEquals([
            "camel_name" => "John"
        ], $decoded);
    }

    public function testToArrayWithoutConversion() {
        $structure = new CamelCaseSerializationWithoutConversionStructure();
        $array = $structure->toArray();
        $this->assertEquals([
            "camelName" => "John"
        ], $array);

        $structure->camelName = "Lightning";
        $array = $structure->toArray();
        $this->assertEquals([
            "camelName" => "Lightning"
        ], $array);
    }

    public function testJsonEncodeWithoutConversion() {
        $encoded = json_encode(new CamelCaseSerializationWithoutConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEquals([
            "camelName" => "John"
        ], $decoded);
    }
}

class CamelCaseSerializationWithConversionStructure extends JsonStructure {
    protected bool $convertCamelToSnakeCase = true;
    public string $camelName = "John";
}

class CamelCaseSerializationWithoutConversionStructure extends JsonStructure {
    protected bool $convertCamelToSnakeCase = false;
    public string $camelName = "John";
}