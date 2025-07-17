<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Apple\Enum\TransitType;
use Raxos\Wallet\WalletHelper;

/**
 * Class BoardingPass
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class BoardingPass extends PassFields
{

    /**
     * BoardingPass constructor.
     *
     * @param TransitType $transitType
     * @param AdditionalInfoField|null $additionalInfoFields
     * @param AuxiliaryField|null $auxiliaryFields
     * @param BackField|null $backFields
     * @param HeaderField|null $headerFields
     * @param PrimaryField|null $primaryFields
     * @param SecondaryField|null $secondaryFields
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public TransitType $transitType,
        ?AdditionalInfoField $additionalInfoFields = null,
        ?AuxiliaryField $auxiliaryFields = null,
        ?BackField $backFields = null,
        ?HeaderField $headerFields = null,
        ?PrimaryField $primaryFields = null,
        ?SecondaryField $secondaryFields = null
    )
    {
        parent::__construct(
            primaryFields: $primaryFields,
            secondaryFields: $secondaryFields,
            additionalInfoFields: $additionalInfoFields,
            auxiliaryFields: $auxiliaryFields,
            backFields: $backFields,
            headerFields: $headerFields
        );
    }

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'transitType' => $this->transitType,
            ...parent::jsonSerialize()
        ], WalletHelper::isNotEmpty(...));
    }

}
