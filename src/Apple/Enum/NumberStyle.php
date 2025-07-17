<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum NumberStyle
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum NumberStyle: string
{
    case DECIMAL = 'PKNumberStyleDecimal';
    case PERCENT = 'PKNumberStylePercent';
    case SCIENTIFIC = 'PKNumberStyleScientific';
    case SPELL_OUT = 'PKNumberStyleSpellOut';
}
