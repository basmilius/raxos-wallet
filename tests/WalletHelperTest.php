<?php
declare(strict_types=1);

use Raxos\Wallet\WalletHelper;

covers(WalletHelper::class);

it('omits only null and empty arrays from component serialization', function (mixed $value, bool $retained): void {
    expect(WalletHelper::isNotEmpty($value))->toBe($retained);
})->with([[null, false], [[], false], [false, true], [0, true], ['', true], [[0], true], ['value', true]]);

it('extracts exact binary bytes from the signature MIME part', function (): void {
    $bytes = "\x30\x03\x00\x01\xff";
    $signature = 'headers filename="smime.p7s"' . "\n\n" . chunk_split(base64_encode($bytes)) . '------boundary';
    expect(WalletHelper::pemToDER($signature))->toBe($bytes);
});

it('rejects missing markers and malformed base64 signatures', function (string $signature): void {
    expect(fn () => WalletHelper::pemToDER($signature))->toThrow(RuntimeException::class);
})->with(['missing markers', 'filename="smime.p7s" without end', 'filename="smime.p7s" !!!! ------boundary']);
