<?php
declare(strict_types=1);

namespace Raxos\Wallet\Apple\Enum;

/**
 * Enum DataDetectorType
 *
 * @author Bas Milius <bas@mili.us>
 * @package Raxos\Wallet\Apple\Enum
 * @since 2.0.0
 */
enum DataDetectorType: string
{
    case ADDRESS = 'PKDataDetectorTypeAddress';
    case CALENDAR_EVENT = 'PKDataDetectorTypeCalendarEvent';
    case LINK = 'PKDataDetectorTypeLink';
    case PHONE_NUMBER = 'PKDataDetectorTypePhoneNumber';
}
