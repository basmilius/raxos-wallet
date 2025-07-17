<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class RelevantDate
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class RelevantDate implements ComponentInterface
{

    /**
     * RelevantDate constructor.
     *
     * @param string|null $date
     * @param string|null $endDate
     * @param string|null $startDate
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public ?string $date = null,
        public ?string $endDate = null,
        public ?string $startDate = null
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'date' => $this->date,
            'endDate' => $this->endDate,
            'startDate' => $this->startDate
        ], WalletHelper::isNotEmpty(...));
    }

}
