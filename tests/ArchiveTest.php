<?php
declare(strict_types=1);

use Raxos\Wallet\Archive;
use function RaxosTests\Wallet\walletZipContents;

covers(Archive::class);

it('adds files and binary contents and returns a self-contained download response', function (): void {
    $archive = new Archive();
    $source = tempnam(sys_get_temp_dir(), 'raxos-wallet-source-');
    file_put_contents($source, 'file bytes');
    try {
        $archive->open();
        $archive->file('file.txt', $source);
        $archive->fileContents('binary.dat', "\x00\xff");
        $archive->close();
        $response = $archive->respond();
        expect(walletZipContents($archive->binary()))->toBe(['file.txt' => 'file bytes', 'binary.dat' => "\x00\xff"])
            ->and($response->data)->toBe($archive->binary())->and($response->headers->get('Content-Transfer-Encoding'))->toBe('binary')
            ->and($response->headers->get('Expires'))->toBe('0');
        $archive->delete();
        expect(is_file($archive->fileName))->toBeFalse()->and($response->data)->toStartWith('PK');
    } finally {
        if (is_file($archive->fileName)) {
            $archive->delete();
        }
        unlink($source);
    }
});
