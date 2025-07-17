<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Apple\Enum\BarcodeFormat;
use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class Barcode
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class Barcode implements ComponentInterface
{

    /**
     * Barcode constructor.
     *
     * @param BarcodeFormat $format
     * @param string $message
     * @param string|null $altText
     * @param string $messageEncoding
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public BarcodeFormat $format,
        public string $message,
        public ?string $altText = null,
        public string $messageEncoding = 'iso-8859-1'
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'altText' => $this->altText,
            'format' => $this->format,
            'message' => $this->message,
            'messageEncoding' => $this->messageEncoding
        ], WalletHelper::isNotEmpty(...));
    }

}
