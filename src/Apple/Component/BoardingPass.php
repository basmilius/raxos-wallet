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
     * @param AdditionalInfoField|AdditionalInfoField[]|null $additionalInfoFields
     * @param AuxiliaryField|AuxiliaryField[]|null $auxiliaryFields
     * @param BackField|BackField[]|null $backFields
     * @param HeaderField|HeaderField[]|null $headerFields
     * @param PrimaryField|PrimaryField[]|null $primaryFields
     * @param SecondaryField|SecondaryField[]|null $secondaryFields
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public TransitType $transitType,
        AdditionalInfoField|array|null $additionalInfoFields = null,
        AuxiliaryField|array|null $auxiliaryFields = null,
        BackField|array|null $backFields = null,
        HeaderField|array|null $headerFields = null,
        PrimaryField|array|null $primaryFields = null,
        SecondaryField|array|null $secondaryFields = null
    )
    {
        parent::__construct(
            primaryFields: $primaryFields instanceof PrimaryField ? [$primaryFields] : $primaryFields,
            secondaryFields: $secondaryFields instanceof SecondaryField ? [$secondaryFields] : $secondaryFields,
            additionalInfoFields: $additionalInfoFields instanceof AdditionalInfoField ? [$additionalInfoFields] : $additionalInfoFields,
            auxiliaryFields: $auxiliaryFields instanceof AuxiliaryField ? [$auxiliaryFields] : $auxiliaryFields,
            backFields: $backFields instanceof BackField ? [$backFields] : $backFields,
            headerFields: $headerFields instanceof HeaderField ? [$headerFields] : $headerFields
        );
    }

    /**
     * {@inheritdoc}
     *
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
