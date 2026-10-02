<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\Barcode;
use Raxos\Wallet\Apple\Enum\BarcodeFormat;

covers(Barcode::class);

it('exports format, message and encoding while omitting absent alternative text', function (BarcodeFormat $format): void {
    expect(json_decode(json_encode(new Barcode($format, 'é', messageEncoding: 'utf-8'), JSON_THROW_ON_ERROR), true))
        ->toBe(['format' => $format->value, 'message' => 'é', 'messageEncoding' => 'utf-8']);
})->with(BarcodeFormat::cases());
