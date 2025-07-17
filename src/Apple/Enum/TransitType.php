<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum TransitType
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum TransitType: string
{
    case AIR = 'PKTransitTypeAir';
    case BOAT = 'PKTransitTypeBoat';
    case BUS = 'PKTransitTypeBus';
    case GENERIC = 'PKTransitTypeGeneric';
    case TRAIN = 'PKTransitTypeTrain';
}
