# HTTP client response types

The HTTP client returns an {@see \Illuminate\Http\Client\Response} whose body
is only known at runtime. This package tightens the safe parts of that API
without inventing JSON shapes PHPStan cannot see.

## Supported methods

```php
$response = Http::get('https://example.test');

$response->json();
// array<mixed>|bool|float|int|string|null

$response->json('data');
// mixed

$response->json('data', 'fallback');
// mixed (the default is absorbed: the payload shape is unknown)

$response->collect();
// Illuminate\Support\Collection<array-key, mixed>

$response->object();
// array<mixed>|bool|float|int|object|string|null

$response->resource();
// resource
```

`json()` always decodes with `$associative = true`, so JSON objects become
arrays (never `stdClass`). That is why the no-key return type excludes
`object`.

## Limitations

- The concrete JSON structure (keys, nested shapes, list element types) is not
  inferred. Prefer application-level DTOs or explicit assertions after decode.
- `collect($key)` does not narrow the collection value type when `$key` points
  at a typed field — values stay `mixed`.
- Custom `json_decode` flags do not change the static return type.
- `fluent()` is left to Laravel's own phpdoc (`Fluent` without generics).
