<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Component;

use Raxos\Wallet\Component\Color;
use Raxos\Wallet\Contract\ComponentInterface;
use Raxos\Wallet\WalletHelper;
use function array_filter;

/**
 * Class Pass
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Component
 * @since 2.0.0
 */
final readonly class Pass implements ComponentInterface
{

    /**
     * Pass constructor.
     *
     * @param string $description
     * @param string $organizationName
     * @param string $serialNumber
     * @param string|null $accessibilityURL
     * @param string|null $addOnURL
     * @param string|null $appLaunchURL
     * @param int[]|null $associatedStoreIdentifiers
     * @param int[]|null $auxiliaryStoreIdentifiers
     * @param string|null $authenticationToken
     * @param Color|null $backgroundColor
     * @param string|null $bagPolicyURL
     * @param Barcode[]|null $barcodes
     * @param Beacon[]|null $beacons
     * @param BoardingPass|null $boardingPass
     * @param string|null $contactVenueEmail
     * @param string|null $contactVenuePhoneNumber
     * @param string|null $contactVenueWebsite
     * @param Coupon|null $coupon
     * @param string|null $directionsInformationURL
     * @param string|null $eventLogoText
     * @param EventTicket|null $eventTicket
     * @param string|null $expirationDate
     * @param Color|null $footerBackgroundColor
     * @param Color|null $foregroundColor
     * @param int $formatVersion
     * @param Generic|null $generic
     * @param string|null $groupingIdentifier
     * @param Color|null $labelColor
     * @param Location[]|null $locations
     * @param string|null $logoText
     * @param float|null $maxDistance
     * @param string|null $merchandiseURL
     * @param NFC|null $nfc
     * @param string|null $orderFoodURL
     * @param string|null $parkingInformationURL
     * @param string[]|null $preferredStyleSchemes
     * @param string|null $purchaseParkingURL
     * @param string|null $relevantDate
     * @param RelevantDate[]|null $relevantDates
     * @param string|null $sellURL
     * @param SemanticTags|null $semanticTags
     * @param bool|null $sharingProhibited
     * @param StoreCard|null $storeCard
     * @param bool|null $suppressStripShine
     * @param bool|null $suppressHeaderDarkening
     * @param string|null $transferURL
     * @param string|null $transitInformationURL
     * @param bool|null $useAutomaticColors
     * @param array|null $userInfo
     * @param bool|null $voided
     * @param string|null $webServiceURL
     *
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function __construct(
        public string $description,
        public string $organizationName,
        public string $serialNumber,
        public ?string $accessibilityURL = null,
        public ?string $addOnURL = null,
        public ?string $appLaunchURL = null,
        public ?array $associatedStoreIdentifiers = [],
        public ?array $auxiliaryStoreIdentifiers = [],
        public ?string $authenticationToken = null,
        public ?Color $backgroundColor = null,
        public ?string $bagPolicyURL = null,
        public ?array $barcodes = [],
        public ?array $beacons = [],
        public ?BoardingPass $boardingPass = null,
        public ?string $contactVenueEmail = null,
        public ?string $contactVenuePhoneNumber = null,
        public ?string $contactVenueWebsite = null,
        public ?Coupon $coupon = null,
        public ?string $directionsInformationURL = null,
        public ?string $eventLogoText = null,
        public ?EventTicket $eventTicket = null,
        public ?string $expirationDate = null,
        public ?Color $footerBackgroundColor = null,
        public ?Color $foregroundColor = null,
        public int $formatVersion = 1,
        public ?Generic $generic = null,
        public ?string $groupingIdentifier = null,
        public ?Color $labelColor = null,
        public ?array $locations = null,
        public ?string $logoText = null,
        public ?float $maxDistance = null,
        public ?string $merchandiseURL = null,
        public ?NFC $nfc = null,
        public ?string $orderFoodURL = null,
        public ?string $parkingInformationURL = null,
        public ?array $preferredStyleSchemes = null,
        public ?string $purchaseParkingURL = null,
        public ?string $relevantDate = null,
        public ?array $relevantDates = null,
        public ?string $sellURL = null,
        public ?SemanticTags $semanticTags = null,
        public ?bool $sharingProhibited = null,
        public ?StoreCard $storeCard = null,
        public ?bool $suppressStripShine = null,
        public ?bool $suppressHeaderDarkening = null,
        public ?string $transferURL = null,
        public ?string $transitInformationURL = null,
        public ?bool $useAutomaticColors = null,
        public ?array $userInfo = [],
        public ?bool $voided = null,
        public ?string $webServiceURL = null
    ) {}

    /**
     * {@inheritdoc}
     * @author Bas Milius <bas@mili.us>
     * @since 2.0.0
     */
    public function jsonSerialize(): array
    {
        return array_filter([
            'accessibilityURL' => $this->accessibilityURL,
            'addOnURL' => $this->addOnURL,
            'appLaunchURL' => $this->appLaunchURL,
            'associatedStoreIdentifiers' => $this->associatedStoreIdentifiers,
            'auxiliaryStoreIdentifiers' => $this->auxiliaryStoreIdentifiers,
            'authenticationToken' => $this->authenticationToken,
            'backgroundColor' => $this->backgroundColor->toRgb(),
            'bagPolicyURL' => $this->bagPolicyURL,
            'barcodes' => $this->barcodes,
            'beacons' => $this->beacons,
            'boardingPass' => $this->boardingPass,
            'contactVenueEmail' => $this->contactVenueEmail,
            'contactVenuePhoneNumber' => $this->contactVenuePhoneNumber,
            'contactVenueWebsite' => $this->contactVenueWebsite,
            'coupon' => $this->coupon,
            'description' => $this->description,
            'directionsInformationURL' => $this->directionsInformationURL,
            'eventLogoText' => $this->eventLogoText,
            'eventTicket' => $this->eventTicket,
            'expirationDate' => $this->expirationDate,
            'footerBackgroundColor' => $this->footerBackgroundColor->toRgb(),
            'foregroundColor' => $this->foregroundColor->toRgb(),
            'formatVersion' => $this->formatVersion,
            'generic' => $this->generic,
            'groupingIdentifier' => $this->groupingIdentifier,
            'labelColor' => $this->labelColor->toRgb(),
            'locations' => $this->locations,
            'logoText' => $this->logoText,
            'maxDistance' => $this->maxDistance,
            'merchandiseURL' => $this->merchandiseURL,
            'nfc' => $this->nfc,
            'orderFoodURL' => $this->orderFoodURL,
            'organizationName' => $this->organizationName,
            'parkingInformationURL' => $this->parkingInformationURL,
            'preferredStyleSchemes' => $this->preferredStyleSchemes,
            'purchaseParkingURL' => $this->purchaseParkingURL,
            'relevantDate' => $this->relevantDate,
            'relevantDates' => $this->relevantDates,
            'sellURL' => $this->sellURL,
            'semanticTags' => $this->semanticTags,
            'serialNumber' => $this->serialNumber,
            'sharingProhibited' => $this->sharingProhibited,
            'storeCard' => $this->storeCard,
            'suppressStripShine' => $this->suppressStripShine,
            'suppressHeaderDarkening' => $this->suppressHeaderDarkening,
            'transferURL' => $this->transferURL,
            'transitInformationURL' => $this->transitInformationURL,
            'useAutomaticColors' => $this->useAutomaticColors,
            'userInfo' => $this->userInfo,
            'voided' => $this->voided,
            'webServiceURL' => $this->webServiceURL
        ], WalletHelper::isNotEmpty(...));
    }

}
