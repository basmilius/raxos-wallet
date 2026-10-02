<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\Pass;
use Raxos\Wallet\Apple\{PKPass, Strings};
use Symfony\Component\Process\Process;
use function RaxosTests\Wallet\{unitIdentity, walletZipContents};

covers(PKPass::class);

it('creates a signed pass with matching file hashes and a verifiable detached signature', function (): void {
    $pass = new PKPass(unitIdentity(), new Pass('Unit pass', 'Raxos', 'unit-serial'));
    $source = tempnam(sys_get_temp_dir(), 'raxos-pass-file-');
    $manifestFile = tempnam(sys_get_temp_dir(), 'raxos-pass-manifest-');
    $signatureFile = tempnam(sys_get_temp_dir(), 'raxos-pass-signature-');
    file_put_contents($source, 'local bytes');
    try {
        $pass->file('local.txt', $source);
        $pass->fileContents('icon.png', "\x00\xff");
        $pass->strings(new Strings('nl')->add('label', 'Naam'));
        $pass->sign();
        $pass->close();
        $files = walletZipContents($pass->binary());
        $manifest = json_decode($files['manifest.json'], true, flags: JSON_THROW_ON_ERROR);
        foreach (['pass.json', 'local.txt', 'icon.png', 'nl.lproj/pass.strings'] as $file) {
            expect($manifest[$file])->toBe(sha1($files[$file]));
        }
        $data = json_decode($files['pass.json'], true, flags: JSON_THROW_ON_ERROR);
        expect($data['passTypeIdentifier'])->toBe('pass.unit')->and($data['teamIdentifier'])->toBe('team.unit')
            ->and($data['serialNumber'])->toBe('unit-serial')->and($files['nl.lproj/pass.strings'])->toBe('"label" = "Naam";');
        file_put_contents($manifestFile, $files['manifest.json']);
        file_put_contents($signatureFile, $files['signature']);
        $verification = new Process(['openssl', 'cms', '-verify', '-inform', 'DER', '-in', $signatureFile, '-content', $manifestFile, '-noverify', '-binary']);
        $verification->run();
        expect($verification->isSuccessful())->toBeTrue()->and($verification->getOutput())->toBe($files['manifest.json']);
        $response = $pass->respond();
        expect($response->headers->get('Content-Type'))->toBe('application/vnd.apple.pkpass')
            ->and($response->headers->get('Content-Disposition'))->toBe('attachment; filename="unit-serial.pkpass"');
    } finally {
        $pass->delete();
        unlink($source);
        unlink($manifestFile);
        unlink($signatureFile);
    }
});
