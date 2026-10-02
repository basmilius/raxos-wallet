<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\{AdditionalInfoField, AuxiliaryField, BackField, HeaderField, PassFields, PrimaryField, SecondaryField};

covers(PassFields::class);

it('serializes each field group using its exact external key', function (): void {
    $fields = new readonly class(
        [new PrimaryField('primary', 0)],
        [new SecondaryField('secondary', 1)],
        [new AdditionalInfoField('additional', 2)],
        [new AuxiliaryField('auxiliary', 3)],
        [new BackField('back', 4)],
        [new HeaderField('header', 5)],
    ) extends PassFields
    {
    };
    $data = json_decode(json_encode($fields, JSON_THROW_ON_ERROR), true);
    expect(array_keys($data))->toBe(['additionalInfoFields', 'auxiliaryFields', 'backFields', 'headerFields', 'primaryFields', 'secondaryFields'])
        ->and($data['primaryFields'])->toBe([['key' => 'primary', 'value' => 0]])->and($data['backFields'])->toBe([['key' => 'back', 'value' => 4]]);
});
