<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\{Barcode, Generic, NFC, Pass, PrimaryField};
use Raxos\Wallet\Apple\Enum\BarcodeFormat;
use Raxos\Wallet\Component\Color;

covers(Pass::class);

it('exports mandatory identifiers and nested components while omitting empty optional fields', function (): void {
    $pass = new Pass(
        'Unit pass',
        'Raxos',
        'serial',
        backgroundColor: new Color(0, 0, 0),
        foregroundColor: new Color(255, 255, 255),
        barcodes: [new Barcode(BarcodeFormat::QR, 'message')],
        generic: new Generic(primaryFields: [new PrimaryField('count', 0)]),
        maxDistance: 0.0,
        nfc: new NFC('key', 'message'),
        sharingProhibited: false,
        userInfo: ['unit' => 0],
        voided: false
    );
    $data = json_decode(json_encode($pass, JSON_THROW_ON_ERROR), true);
    expect($data['backgroundColor'])->toBe('rgb(0, 0, 0)')->and($data['foregroundColor'])->toBe('rgb(255, 255, 255)')
        ->and($data['generic']['primaryFields'][0]['value'])->toBe(0)->and($data['maxDistance'])->toBe(0)
        ->and($data['sharingProhibited'])->toBeFalse()->and($data['voided'])->toBeFalse()->and($data['userInfo'])->toBe(['unit' => 0])
        ->and($data['nfc']['requiresAuthentication'])->toBeFalse()->and($data)->not->toHaveKeys(['coupon', 'eventTicket', 'relevantDate', 'beacons']);
});
