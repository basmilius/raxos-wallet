<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\BackField;
use Raxos\Wallet\Apple\Enum\TextAlignment;

covers(BackField::class);

it('exports the field wire format and retains false and zero', function (): void {
    $field = new BackField('count', 0, isRelative: false, ignoresTimeZone: false, label: 'Count', textAlignment: TextAlignment::RIGHT);
    expect(json_decode(json_encode($field, JSON_THROW_ON_ERROR), true))->toBe(['ignoresTimeZone' => false, 'isRelative' => false, 'key' => 'count', 'label' => 'Count', 'textAlignment' => TextAlignment::RIGHT->value, 'value' => 0]);
    expect(new BackField('name', 'value')->jsonSerialize())->toBe(['key' => 'name', 'value' => 'value']);
});
