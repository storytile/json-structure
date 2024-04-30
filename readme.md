# Intention for JsonStructure
The `JsonStructure` is intended to help you when you work with non-trivial JSON structures from an unstructured source.
This source could e.g. be your database, that store the JSON, but when retrieved simply gives you a string or maybe
already an associative array. You then have the data, and you most likely know how the data is (or should be) structured,
but you don't still only have an associated array or maybe an object, depending on how you used `json_decode`.

Enter `JsonStructure`.

With `JsonStructure` you create a new class that inherits form `JsonStructure`, e.g. `MyDataStructure`. In your derived
class you define public properties for all the properties that the JSON has. You can also nest your classes.

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
$myData = MyDataStructure::fromJson([
    "name" => "Jim",
    "details" => [
        "counter" => 42
    ]
]);

echo $myData->name; // Jim
echo $myData->preferredColor; // red
echo $myData->details->counter; // 42
```

Now you have a defined structure, intellisense-supported by your IDE and with default values (if you specified some).
No more need to remember how the properties in your JSON are named and nested.

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