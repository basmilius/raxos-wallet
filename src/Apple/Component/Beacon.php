<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class Beacon
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class Beacon implements ComponentInterface
{

    /**
     * Beacon constructor.
     *
     * @param string $proximityUUID
     * @param int|null $major
     * @param int|null $minor
     * @param string|null $relevantText
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $proximityUUID,
        public ?int $major = null,
        public ?int $minor = null,
        public ?string $relevantText = null
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'major' => $this->major,
            'minor' => $this->minor,
            'proximityUUID' => $this->proximityUUID,
            'relevantText' => $this->relevantText
        ], WalletHelper::isNotEmpty(...));
    }

}
