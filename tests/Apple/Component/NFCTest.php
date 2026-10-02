<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\NFC;

covers(NFC::class);

it('exports exact component keys without dropping falsey values', function (): void {
    expect(json_decode(json_encode(new NFC('public-key', 'message'), JSON_THROW_ON_ERROR), true))->toBe(['encryptionPublicKey' => 'public-key', 'message' => 'message', 'requiresAuthentication' => false]);
});
