<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum DateStyle
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum DateStyle: string
{
    case FULL = 'PKDateStyleFull';
    case LONG = 'PKDateStyleLong';
    case MEDIUM = 'PKDateStyleMedium';
    case NONE = 'PKDateStyleNone';
    case SHORT = 'PKDateStyleShort';
}
