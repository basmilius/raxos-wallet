<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\{PrimaryField, StoreCard};

covers(StoreCard::class);

it('exports populated field groups and omits empty optional groups', function (): void {
    $field = new PrimaryField('name', 'value');
    expect(json_decode(json_encode(new StoreCard(primaryFields: [$field], backFields: []), JSON_THROW_ON_ERROR), true))->toBe(['primaryFields' => [['key' => 'name', 'value' => 'value']]])
        ->and(new StoreCard()->jsonSerialize())->toBe([]);
});
