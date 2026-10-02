<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\Location;

covers(Location::class);

it('exports exact component keys without dropping falsey values', function (): void {
    expect(json_decode(json_encode(new Location(0.0, 0.0, 0.0, 'Here'), JSON_THROW_ON_ERROR), true))->toBe(['altitude' => 0, 'latitude' => 0, 'longitude' => 0, 'relevantText' => 'Here']);
});
