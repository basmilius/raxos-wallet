<?php
declare(strict_types=1);

use Raxos\Wallet\Component\Color;

covers(Color::class);

it('round trips channel boundaries through hex, RGB and JSON', function (string $hex, string $rgb): void {
    $color = Color::fromHex($hex);
    expect($color->toHex())->toBe($hex)->and($color->toRgb())->toBe($rgb)->and($color->jsonSerialize())->toBe($rgb);
})->with([['#000000', 'rgb(0, 0, 0)'], ['#ffffff', 'rgb(255, 255, 255)'], ['#285e91', 'rgb(40, 94, 145)']]);
