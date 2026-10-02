<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\RelevantDate;

covers(RelevantDate::class);

it('exports exact component keys without dropping falsey values', function (): void {
    expect(json_decode(json_encode(new RelevantDate('2026-01-01', '2026-01-03', '2026-01-02'), JSON_THROW_ON_ERROR), true))->toBe(['date' => '2026-01-01', 'endDate' => '2026-01-03', 'startDate' => '2026-01-02']);
});
