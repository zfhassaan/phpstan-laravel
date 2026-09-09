<?php

declare(strict_types=1);

namespace HttpClientResponse;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

use function PHPStan\Testing\assertType;

function test(Response $response): void
{
    assertType('array<mixed>|bool|float|int|string|null', $response->json());
    assertType('mixed', $response->json('data'));
    assertType('mixed', $response->json('data', null));
    assertType('mixed', $response->json('data', 'fallback'));
    assertType('array<mixed>|bool|float|int|string|null', $response->json(null, 'ignored'));

    assertType('array<mixed>|bool|float|int|object|string|null', $response->object());

    assertType('Illuminate\Support\Collection<(int|string), mixed>', $response->collect());
    assertType('Illuminate\Support\Collection<(int|string), mixed>', $response->collect('items'));

    assertType('resource', $response->resource());

    $fromHttp = Http::get('https://example.test');
    assertType('array<mixed>|bool|float|int|string|null', $fromHttp->json());
    assertType('Illuminate\Support\Collection<(int|string), mixed>', $fromHttp->collect());
    assertType('array<mixed>|bool|float|int|object|string|null', $fromHttp->object());
    assertType('resource', $fromHttp->resource());
}
