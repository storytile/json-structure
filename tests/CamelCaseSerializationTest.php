<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class CamelCaseSerializationTest extends TestCase
{
    public function testToArrayWithConversion() {
        $structure = new CamelCaseSerializationWithConversionStructure();
        $array = $structure->toArray();
        $this->assertEqualsCanonicalizing([
            "camel_name" => "John"
        ], $array);
        $this->assertArrayHasKey("camel_name", $array);

        $structure->camelName = "Lightning";
        $array = $structure->toArray();
        $this->assertEqualsCanonicalizing([
            "camel_name" => "Lightning"
        ], $array);
        $this->assertArrayHasKey("camel_name", $array);
    }

    public function testJsonEncodeWithConversion() {
        $encoded = json_encode(new CamelCaseSerializationWithConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEqualsCanonicalizing([
            "camel_name" => "John"
        ], $decoded);
        $this->assertArrayHasKey("camel_name", $decoded);
    }

    public function testToArrayWithoutConversion() {
        $structure = new CamelCaseSerializationWithoutConversionStructure();
        $array = $structure->toArray();
        $this->assertEqualsCanonicalizing([
            "camelName" => "John"
        ], $array);
        $this->assertArrayHasKey("camelName", $array);

        $structure->camelName = "Lightning";
        $array = $structure->toArray();
        $this->assertEqualsCanonicalizing([
            "camelName" => "Lightning"
        ], $array);
        $this->assertArrayHasKey("camelName", $array);
    }

    public function testJsonEncodeWithoutConversion() {
        $encoded = json_encode(new CamelCaseSerializationWithoutConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEqualsCanonicalizing([
            "camelName" => "John"
        ], $decoded);
        $this->assertArrayHasKey("camelName", $decoded);
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