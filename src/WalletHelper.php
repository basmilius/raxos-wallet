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

        $signature = substr($signature, strpos($signature, $begin) + strlen($begin));
        $signature = substr($signature, 0, strpos($signature, $end));
        $signature = trim($signature);

        return base64_decode($signature);
    }

}
