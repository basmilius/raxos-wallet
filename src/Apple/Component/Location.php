<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class Location
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class Location implements ComponentInterface
{

    /**
     * Location constructor.
     *
     * @param float $latitude
     * @param float $longitude
     * @param float|null $altitude
     * @param string|null $relevantText
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?float $altitude = null,
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
            'altitude' => $this->altitude,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'relevantText' => $this->relevantText
        ], WalletHelper::isNotEmpty(...));
    }

}
