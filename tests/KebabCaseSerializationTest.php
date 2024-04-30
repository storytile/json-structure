<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\Attributes\KebabCase;
use Storytile\JsonStructure\JsonStructure;

class KebabCaseSerializationTest extends TestCase
{
    public function testToArrayWithConversion() {
        $structure = new KebabCaseSerializationWithConversionStructure();
        $array = $structure->toArray();
        $this->assertEquals([
            "camel_name" => "John",
            "kebab-name" => "Jim"
        ], $array);

        $structure->camelName = "Lightning";
        $structure->kebabName = "Fast";
        $array = $structure->toArray();
        $this->assertEquals([
            "camel_name" => "Lightning",
            "kebab-name" => "Fast"
        ], $array);
    }

    public function testJsonEncodeWithConversion() {
        $encoded = json_encode(new KebabCaseSerializationWithConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEquals([
            "camel_name" => "John",
            "kebab-name" => "Jim"
        ], $decoded);
    }

    public function testToArrayWithoutConversion() {
        $structure = new KebabCaseSerializationWithoutConversionStructure();
        $array = $structure->toArray();
        $this->assertEquals([
            "camelName" => "John",
            "kebab-name" => "Jim"
        ], $array);

        $structure->camelName = "Lightning";
        $structure->kebabName = "Fast";
        $array = $structure->toArray();
        $this->assertEquals([
            "camelName" => "Lightning",
            "kebab-name" => "Fast"
        ], $array);
    }

    public function testJsonEncodeWithoutConversion() {
        $encoded = json_encode(new KebabCaseSerializationWithoutConversionStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEquals([
            "camelName" => "John",
            "kebab-name" => "Jim"
        ], $decoded);
    }
}

class KebabCaseSerializationWithConversionStructure extends JsonStructure {
    protected bool $convertCamelToSnakeCase = true;
    public string $camelName = "John";

    #[KebabCase]
    public string $kebabName = "Jim";
}

class KebabCaseSerializationWithoutConversionStructure extends JsonStructure {
    protected bool $convertCamelToSnakeCase = false;
    public string $camelName = "John";

    #[KebabCase]
    public string $kebabName = "Jim";
}