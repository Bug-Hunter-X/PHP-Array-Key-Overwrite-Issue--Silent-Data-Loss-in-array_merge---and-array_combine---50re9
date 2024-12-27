To avoid data loss due to key overwriting, consider these strategies:

1. **Check for Duplicate Keys:** Before merging, inspect arrays for duplicate keys and handle them accordingly.  You might choose to throw an error, re-index the arrays, or implement a custom merge logic that aggregates data instead of overwriting.

2. **Use `array_replace()`:** Instead of `array_merge()`, use `array_replace()`. This function replaces values associated with the same keys rather than overwriting them. However, it only replaces values from the second array, not merging the arrays completely.

3. **Unique Key Generation:** If possible, generate unique keys during array creation, eliminating the possibility of duplicates entirely.

4. **Custom Merge Function:** Create your own merge function to provide fine-grained control. This allows you to choose a suitable strategy for handling key collisions.

Here's an example using a custom merge function:

```php
<?php
function safeArrayMerge(array $array1, array $array2): array {
    $merged = $array1;
    foreach ($array2 as $key => $value) {
        if (array_key_exists($key, $merged)) {
            // Handle duplicate keys - append to an array or choose a specific value.
            $merged[$key] = is_array($merged[$key]) ? array_merge($merged[$key], [$value]) : [$merged[$key], $value];
        } else {
            $merged[$key] = $value;
        }
    }
    return $merged;
}

$array1 = ['a' => 1, 'b' => 2];
$array2 = ['b' => 3, 'c' => 4];
$merged = safeArrayMerge($array1, $array2);
print_r($merged);
//Output: Array ( [a] => 1 [b] => Array ( [0] => 2 [1] => 3 ) [c] => 4 )
?>
```