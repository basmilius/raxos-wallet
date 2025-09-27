<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Contract\Wallet\ComponentInterface;
use Raxos\Wallet\Apple\Enum\{DataDetectorType, DateStyle, NumberStyle, TextAlignment};
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class PassFieldContent
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
abstract readonly class PassFieldContent implements ComponentInterface
{

    /**
     * PassFieldContent constructor.
     *
     * @param string $key
     * @param string|int $value
     * @param string|null $attributedValue
     * @param string|null $changeMessage
     * @param string|null $currencyCode
     * @param DataDetectorType[]|null $dataDetectorTypes
     * @param DateStyle|null $dateStyle
     * @param bool|null $ignoresTimeZone
     * @param bool|null $isRelative
     * @param string|null $label
     * @param NumberStyle|null $numberStyle
     * @param TextAlignment|null $textAlignment
     * @param DateStyle|null $timeStyle
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $key,
        public string|int $value,
        public ?string $attributedValue = null,
        public ?string $changeMessage = null,
        public ?string $currencyCode = null,
        public ?array $dataDetectorTypes = null,
        public ?DateStyle $dateStyle = null,
        public ?bool $ignoresTimeZone = null,
        public ?bool $isRelative = null,
        public ?string $label = null,
        public ?NumberStyle $numberStyle = null,
        public ?TextAlignment $textAlignment = null,
        public ?DateStyle $timeStyle = null,
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'attributedValue' => $this->attributedValue,
            'changeMessage' => $this->changeMessage,
            'currencyCode' => $this->currencyCode,
            'dataDetectorTypes' => $this->dataDetectorTypes,
            'dateStyle' => $this->dateStyle,
            'ignoresTimeZone' => $this->ignoresTimeZone,
            'isRelative' => $this->isRelative,
            'key' => $this->key,
            'label' => $this->label,
            'numberStyle' => $this->numberStyle,
            'textAlignment' => $this->textAlignment,
            'timeStyle' => $this->timeStyle,
            'value' => $this->value
        ], WalletHelper::isNotEmpty(...));
    }

}
