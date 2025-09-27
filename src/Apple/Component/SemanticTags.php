<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Contract\Wallet\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class SemanticTags
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class SemanticTags implements ComponentInterface
{

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([], WalletHelper::isNotEmpty(...));
    }

}
