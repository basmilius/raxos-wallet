<?php
declare(strict_types=1);

namespace RaxosTests\Wallet;

use Raxos\Wallet\Apple\Identity;
use ZipArchive;

function unitIdentity(): Identity
{
    static $identity;
    if ($identity !== null) {
        return $identity;
    }
    $key = openssl_pkey_new(['private_key_bits' => 2048, 'private_key_type' => OPENSSL_KEYTYPE_RSA]);
    $csr = openssl_csr_new(['commonName' => 'Raxos unit signing certificate'], $key, ['digest_alg' => 'sha256']);
    $certificate = openssl_csr_sign($csr, null, $key, 1, ['digest_alg' => 'sha256']);
    openssl_x509_export($certificate, $certificatePem);
    openssl_pkey_export($key, $privateKeyPem, 'unit-password');
    return $identity = new Identity($certificatePem, $privateKeyPem, 'unit-password', 'pass.unit', 'team.unit');
}

function walletZipContents(string $binary): array
{
    $file = tempnam(sys_get_temp_dir(), 'raxos-wallet-zip-');
    file_put_contents($file, $binary);
    $zip = new ZipArchive();
    try {
        if ($zip->open($file) !== true) {
            throw new \RuntimeException('Invalid wallet ZIP.');
        }
        $contents = [];
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $name = $zip->getNameIndex($i);
            $contents[$name] = $zip->getFromIndex($i);
        }
        $zip->close();
        return $contents;
    } finally {
        unlink($file);
    }
}
