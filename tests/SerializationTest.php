<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class SerializationTest extends TestCase
{
    public function testJsonEncode() {
        $encoded = json_encode(new SerializationStructure());
        $decoded = json_decode($encoded, true);
        $this->assertEquals([
            "name" => "Peter",
            "sizes" => [
                12, 13, 14
            ],
            "address" => [
                "city" => "Tokyo"
            ]
        ], $decoded);
    }

    public function testToArray() {
        $array = (new SerializationStructure())->toArray();
        $this->assertEquals([
            "name" => "Peter",
            "sizes" => [
                12, 13, 14
            ],
            "address" => [
                "city" => "Tokyo"
            ]
        ], $array);
    }
}

class SerializationStructure extends JsonStructure {
    public string $name = "Peter";
    public array $sizes = [12, 13, 14];
    private string $secret = "hidden";
    public NestedSerializationStructure $address;

    public function __construct()
    {
        $this->address = new NestedSerializationStructure();
    }
}

class NestedSerializationStructure extends JsonStructure {
    public string $city = "Tokyo";
}