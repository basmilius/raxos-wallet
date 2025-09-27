<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Contract\Wallet\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class PassFields
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
abstract readonly class PassFields implements ComponentInterface
{

    /**
     * PassFields constructor.
     *
     * @param PrimaryField[]|null $primaryFields
     * @param SecondaryField[]|null $secondaryFields
     * @param AdditionalInfoField[]|null $additionalInfoFields
     * @param AuxiliaryField[]|null $auxiliaryFields
     * @param BackField[]|null $backFields
     * @param HeaderField[]|null $headerFields
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public ?array $primaryFields = null,
        public ?array $secondaryFields = null,
        public ?array $additionalInfoFields = null,
        public ?array $auxiliaryFields = null,
        public ?array $backFields = null,
        public ?array $headerFields = null
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'additionalInfoFields' => $this->additionalInfoFields,
            'auxiliaryFields' => $this->auxiliaryFields,
            'backFields' => $this->backFields,
            'headerFields' => $this->headerFields,
            'primaryFields' => $this->primaryFields,
            'secondaryFields' => $this->secondaryFields
        ], WalletHelper::isNotEmpty(...));
    }

}
