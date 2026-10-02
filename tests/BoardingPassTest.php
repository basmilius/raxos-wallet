<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\BoardingPass;
use Raxos\Wallet\Apple\Component\PrimaryField;
use Raxos\Wallet\Apple\Enum\TransitType;

it('accepts one field and field arrays consistently', function (): void {
    $field = new PrimaryField('flight', 'ABC');
    $single = new BoardingPass(TransitType::AIR, primaryFields: $field);
    $multiple = new BoardingPass(TransitType::AIR, primaryFields: [$field]);
    expect(json_encode($single))->toBe(json_encode($multiple));
    expect(json_decode(json_encode($single), true)['primaryFields'][0]['value'])->toBe('ABC');
});

it('serializes a boarding pass without optional fields', function (): void {
    expect(json_decode(json_encode(new BoardingPass(TransitType::AIR)), true))->toBe(['transitType' => TransitType::AIR->value]);
});
