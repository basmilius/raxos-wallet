<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\PassFieldContent;
use Raxos\Wallet\Apple\Enum\{DataDetectorType, DateStyle, NumberStyle, TextAlignment};

covers(PassFieldContent::class);

it('serializes presentation enums, optional text and falsey flags', function (): void {
    $field = new readonly class('key', 'value', 'attributed', 'changed', 'EUR', [DataDetectorType::LINK], DateStyle::SHORT, false, false, '', NumberStyle::DECIMAL, TextAlignment::LEFT, DateStyle::NONE) extends PassFieldContent {};
    $data = json_decode(json_encode($field, JSON_THROW_ON_ERROR), true);
    expect($data['dateStyle'])->toBe(DateStyle::SHORT->value)->and($data['timeStyle'])->toBe(DateStyle::NONE->value)
        ->and($data['numberStyle'])->toBe(NumberStyle::DECIMAL->value)->and($data['textAlignment'])->toBe(TextAlignment::LEFT->value)
        ->and($data['dataDetectorTypes'])->toBe([DataDetectorType::LINK->value])->and($data['label'])->toBe('')->and($data['ignoresTimeZone'])->toBeFalse();
});
