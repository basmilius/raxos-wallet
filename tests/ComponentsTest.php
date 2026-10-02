<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\{Barcode, Pass, PrimaryField};
use Raxos\Wallet\Apple\Enum\BarcodeFormat;
use Raxos\Wallet\Apple\Strings;
use Raxos\Wallet\Archive;
use Raxos\Wallet\Component\Color;

it('preserves explicit false and zero values in the Apple wire format', function (): void {
    $pass = new Pass('Test pass', 'Raxos', 'serial', maxDistance: 0.0, voided: false, sharingProhibited: false);
    $data = json_decode(json_encode($pass, JSON_THROW_ON_ERROR), true);
    expect($data['voided'])->toBeFalse()->and($data['sharingProhibited'])->toBeFalse()
        ->and($data['maxDistance'])->toEqual(0)->and($data)->not->toHaveKey('barcodes');
    expect(new PrimaryField('count', 0, isRelative: false)->jsonSerialize())->toBe(['isRelative' => false, 'key' => 'count', 'value' => 0]);
});

it('exports every supported Apple barcode format', function (BarcodeFormat $format): void {
    $data = json_decode(json_encode(new Barcode($format, 'payload', 'label')), true);
    expect($data)->toBe(['altText' => 'label', 'format' => $format->value, 'message' => 'payload', 'messageEncoding' => 'iso-8859-1']);
})->with(BarcodeFormat::cases());

it('converts colors and uses the Apple RGB representation', function (): void {
    $color = Color::fromHex('#285e91');
    expect($color->toHex())->toBe('#285e91')->and($color->toRgb())->toBe('rgb(40, 94, 145)')
        ->and(json_encode($color))->toBe('"rgb(40, 94, 145)"');
});

it('escapes localized strings without altering Unicode', function (): void {
    $strings = new Strings('nl');
    $strings->add('label', "é\n\"quote\"\\path");
    expect((string)$strings)->toBe('"label" = "é\\n\\"quote\\"\\\\path";');
});

it('creates a readable ZIP with exact file contents and deletes the temporary artifact', function (): void {
    $archive = new Archive();
    try {
        $archive->open();
        $archive->fileContents('pass.json', '{"serialNumber":"test"}');
        $archive->fileContents('nl.lproj/pass.strings', '"name" = "Naam";');
        $archive->close();
        expect($archive->binary())->toStartWith('PK');
        $zip = new ZipArchive();
        expect($zip->open($archive->fileName))->toBeTrue();
        expect($zip->getFromName('pass.json'))->toBe('{"serialNumber":"test"}')
            ->and($zip->getFromName('nl.lproj/pass.strings'))->toBe('"name" = "Naam";')
            ->and($zip->numFiles)->toBe(2);
        $zip->close();
    } finally {
        $archive->delete();
    }
    expect(is_file($archive->fileName))->toBeFalse();
});
