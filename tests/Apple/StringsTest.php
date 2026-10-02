<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Strings;

covers(Strings::class);

it('escapes constructor entries and appended entries identically', function (): void {
    $key = 'a"b';
    $value = "é\n\r\"quote\"\\path";
    expect((string)new Strings('nl', [$key => $value]))->toBe((string)new Strings('nl')->add($key, $value));
});

it('overwrites keys fluently and preserves insertion order and Unicode', function (): void {
    $strings = new Strings('nl');
    expect($strings->add('first', 'old'))->toBe($strings)->and($strings->add('second', 'é'))->toBe($strings);
    $strings->add('first', 'new');
    expect((string)$strings)->toBe('"first" = "new";' . PHP_EOL . '"second" = "é";')->and($strings->language)->toBe('nl')
        ->and((string)new Strings('nl'))->toBe('');
});
