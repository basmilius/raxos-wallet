<?php
declare(strict_types=1);

namespace Raxos\Wallet;

use function base64_decode;
use function is_array;
use function strlen;
use function strpos;
use function substr;
use function trim;

/**
 * Class WalletHelper
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet
 * @since 2.0.0
 * @internal
 * @private
 */
final class WalletHelper
{

    /**
     * Checks if the given value is not considered empty.
     *
     * @param mixed $value
     *
     * @return bool
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public static function isNotEmpty(mixed $value): bool
    {
        return $value !== null && (!is_array($value) || !empty($value));
    }

    /**
     * Converts a PEM signature into the DER format.
     *
     * @param string $signature
     *
     * @return string
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public static function pemToDER(string $signature): string
    {
        $begin = 'filename="smime.p7s"';
        $end = '------';

        $beginPos = strpos($signature, $begin);

        if ($beginPos === false) {
            throw new \RuntimeException('Invalid PEM signature: missing begin marker.');
        }

        $signature = substr($signature, $beginPos + strlen($begin));

        $endPos = strpos($signature, $end);

        if ($endPos === false) {
            throw new \RuntimeException('Invalid PEM signature: missing end marker.');
        }

        $signature = substr($signature, 0, $endPos);
        $signature = trim($signature);

        return base64_decode($signature);
    }

}
