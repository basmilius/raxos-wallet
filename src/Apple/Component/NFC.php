<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class NFC
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class NFC implements ComponentInterface
{

    /**
     * NFC constructor.
     *
     * @param string $encryptionPublicKey
     * @param string $message
     * @param bool $requiresAuthentication
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $encryptionPublicKey,
        public string $message,
        public bool $requiresAuthentication = false
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'encryptionPublicKey' => $this->encryptionPublicKey,
            'message' => $this->message,
            'requiresAuthentication' => $this->requiresAuthentication
        ], WalletHelper::isNotEmpty(...));
    }

}
