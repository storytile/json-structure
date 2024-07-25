<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Storytile\JsonStructure\JsonStructure;

class UnmappedKeysTest extends TestCase
{
    public function testKeepUnmappedKeys()
    {
        $data = [
            "name" => "Peter",
            "age" => 42,
            "address" => [
                "city" => "Tokyo"
            ],
            "unmapped" => "Hello World",
            "another" => [
                "this" => [
                    "key" => "is not mapped"
                ]
            ]
        ];

        $structure = UnmappedKeysTestStructure::fromJson($data, true);
        $this->assertEquals("Peter", $structure->name);
        $this->assertEquals(42, $structure->age);
        $this->assertEquals("Tokyo", $structure->address->city);

        $backConverted = json_decode(json_encode($structure), true);
        $this->assertEquals($data, $backConverted);
    }

    public function testKeepUnmappedKeysByDefault()
    {
        $data = [
            "name" => "Peter",
            "age" => 42,
            "address" => [
                "city" => "Tokyo"
            ],
            "unmapped" => "Hello World",
            "another" => [
                "this" => [
                    "key" => "is not mapped"
                ]
            ]
        ];

        $structure = UnmappedKeysTestStructure::fromJson($data);
        $this->assertEquals("Peter", $structure->name);
        $this->assertEquals(42, $structure->age);
        $this->assertEquals("Tokyo", $structure->address->city);

        $backConverted = json_decode(json_encode($structure), true);
        $this->assertEquals($data, $backConverted);
    }

    public function testIgnoreUnmappedKeys()
    {
        $data = [
            "name" => "Peter",
            "age" => 42,
            "address" => [
                "city" => "Tokyo"
            ],
            "unmapped" => "Hello World",
            "another" => [
                "this" => [
                    "key" => "is not mapped"
                ]
            ]
        ];

        $structure = UnmappedKeysTestStructure::fromJson($data, false);
        $this->assertEquals("Peter", $structure->name);
        $this->assertEquals(42, $structure->age);
        $this->assertEquals("Tokyo", $structure->address->city);

        $backConverted = json_decode(json_encode($structure), true);
        $this->assertEquals([
            "name" => "Peter",
            "age" => 42,
            "address" => [
                "city" => "Tokyo"
            ],
        ], $backConverted);
    }
}

class UnmappedKeysTestStructure extends JsonStructure
{
    public string $name = "";
    public int $age = 0;
    public NestedUnmappedKeysTestStructure $address;

    public function __construct()
    {
        $this->address = new NestedUnmappedKeysTestStructure();
    }
}

class NestedUnmappedKeysTestStructure extends JsonStructure
{
    public string $city = "";
}