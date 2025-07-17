<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple;

/**
 * Class Identity
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple
 * @since 2.0.0
 */
final readonly class Identity
{

    /**
     * Identity constructor.
     *
     * @param string $certificate
     * @param string $privateKey
     * @param string $password
     * @param string $passTypeIdentifier
     * @param string $teamIdentifier
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $certificate,
        public string $privateKey,
        public string $password,
        public string $passTypeIdentifier,
        public string $teamIdentifier
    ) {}

}
