<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum BarcodeFormat
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum BarcodeFormat: string
{
    case AZTEC = 'PKBarcodeFormatAztec';
    case CODE128 = 'PKBarcodeFormatCode128';
    case PDF417 = 'PKBarcodeFormatPDF417';
    case QR = 'PKBarcodeFormatQR';
}
