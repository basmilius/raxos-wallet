<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\{EventTicket, PrimaryField};

covers(EventTicket::class);

it('exports populated field groups and omits empty optional groups', function (): void {
    $field = new PrimaryField('name', 'value');
    expect(json_decode(json_encode(new EventTicket(primaryFields: [$field], backFields: []), JSON_THROW_ON_ERROR), true))->toBe(['primaryFields' => [['key' => 'name', 'value' => 'value']]])
        ->and(new EventTicket()->jsonSerialize())->toBe([]);
});
