<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\Beacon;

covers(Beacon::class);

it('exports exact component keys without dropping falsey values', function (): void {
    expect(json_decode(json_encode(new Beacon('uuid', 0, 0, 'Nearby'), JSON_THROW_ON_ERROR), true))->toBe(['major' => 0, 'minor' => 0, 'proximityUUID' => 'uuid', 'relevantText' => 'Nearby']);
});
