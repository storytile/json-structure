# Intention for JsonStructure
The `JsonStructure` is intended to help you when you work with non-trivial JSON structures from an unstructured source.
This source could e.g. be your database, that stores the JSON, but when retrieved simply gives you a string or maybe
already an associative array. You then have the data, and you most likely know how the data is (or should be) structured,
but you don't still only have an associative array or maybe an object, depending on how you used `json_decode`.

Enter `JsonStructure`.

With `JsonStructure` you create a new class that inherits form `JsonStructure`, e.g. `MyDataStructure`. In your derived
class you define public properties for all the keys that the JSON has. You can also nest your classes.

```PHP
class MyDataStructure extends JsonStructure {
    public string $name = "";
    public string $preferredColor = "red";
    public MyDetailStructure|null $details = null;
}

class MyDetailStructure extends JsonStructure {
    public int $counter = 0;
}
```

Then, instead of directly working with the JSON string/array, you create a structure class from it:
```PHP
$json = json_encode([
    "name" => "Jim",
    "details" => [
        "counter" => 42
    ]
]);
$myData = MyDataStructure::fromJson($json);

echo $myData->name; // Jim
echo $myData->preferredColor; // red
echo $myData->details->counter; // 42
```

Now you have a defined structure, intellisense-supported by your IDE and with default values (if you specified some).
No more need to remember how the properties in your JSON are named and nested.

If you already have the data a associative array, you can directly provide the array:
```PHP
$myData = MyDataStructure::fromJson([
    "name" => "Jim",
    "details" => [
        "counter" => 42
    ]
]);
```

## Unmapped Data
By default, keys that do not map to a property of the JsonStructure are kept internally and added back when JsonStructure is serialized.

This is done to prevent losing data that was forgotten in the mapping process when using a workflow like this:
```
Database -> JSON -> JsonStructure, manipulate data -> JSON -> Database
```

You can, however, use the JsonStructure as a kind of filter that will throw away any unmapped key of the input data:
```PHP
$myData = MyDataStructure::fromJson($json, keepUnmappedKeys: false);
```

## camelCase to snake_case
By default, `JsonStructure` will convert the PHP property name from camelCase to snake_case when trying to fill it from
the provided JSON data. So for `public string $preferredColor` it will look for `preferred_color` in the JSON data.

You can disable this behavior by overwriting `protected bool $convertCamelToSnakeCase = true` in your structure class.

## camelCase to kebab-case
As mentioned, by default the property names will be converted to snake_case. You can however use the attribute `#[KebabCase]` to have an individual variable be converted to kebab-case instead.
```PHP
class MyDataStructure extends JsonStructure {
    #[KebabCase]
    public string $camelCaseVariable = "red";
}
```
This works independent of the snake_case setting, but is (currently) only possible with single properties.

## Typed Arrays
As JSON structures often contain arrays of more structured data, you can use `#[ArrayOf(OtherJsonStructure::class)]` to type an array. Otherwise, the `JsonStructure` won't be able to apply any structure to the array content.
You can additionally use an `@var array<InnerStructure>` with most IDEs to enable type hinting.
```PHP
class OuterStructure extends JsonStructure {
    /**
     * @var array<InnerStructure> 
     */
    #[ArrayOf(InnerStructure::class)]
    public array $innerStructure = [];
}

class InnerStructure extends JsonStructure {
    public string $details = "";
}
```