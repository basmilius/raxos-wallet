<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Identity;
use function RaxosTests\Wallet\unitIdentity;

covers(Identity::class);

it('preserves signing material and the identifiers without altering certificate contents', function (): void {
    $identity = unitIdentity();
    expect($identity->passTypeIdentifier)->toBe('pass.unit')->and($identity->teamIdentifier)->toBe('team.unit')
        ->and(openssl_x509_read($identity->certificate))->toBeInstanceOf(OpenSSLCertificate::class)
        ->and(openssl_pkey_get_private($identity->privateKey, $identity->password))->toBeInstanceOf(OpenSSLAsymmetricKey::class);
});
