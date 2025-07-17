<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum TextAlignment
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum TextAlignment: string
{
    case CENTER = 'PKTextAlignmentCenter';
    case LEFT = 'PKTextAlignmentLeft';
    case NATURAL = 'PKTextAlignmentNatural';
    case RIGHT = 'PKTextAlignmentRight';
}
