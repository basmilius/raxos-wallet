<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\{PKPass, PKPassBundle};
use Raxos\Wallet\Apple\Component\Pass;
use function RaxosTests\Wallet\{unitIdentity, walletZipContents};

covers(PKPassBundle::class);

it('bundles exact pass bytes under each serial filename and supplies bundle download headers', function (): void {
    $pass = new PKPass(unitIdentity(), new Pass('Unit pass', 'Raxos', 'unit'));
    $bundle = new PKPassBundle('tickets.pkpasses');
    try {
        $pass->close();
        $bundle->add($pass);
        $bundle->close();
        $files = walletZipContents($bundle->binary());
        expect($files)->toBe(['unit.pkpass' => $pass->binary()])
            ->and(json_decode(walletZipContents($files['unit.pkpass'])['pass.json'], true)['serialNumber'])->toBe('unit');
        $response = $bundle->respond();
        expect($response->headers->get('Content-Type'))->toBe('application/vnd.apple.pkpasses')
            ->and($response->headers->get('Content-Disposition'))->toBe('attachment; filename="tickets.pkpasses"');
    } finally {
        $pass->delete();
        $bundle->delete();
    }
});
