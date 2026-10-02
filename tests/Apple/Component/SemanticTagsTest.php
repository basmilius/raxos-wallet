<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\SemanticTags;

covers(SemanticTags::class);

it('exports exact component keys without dropping falsey values', function (): void {
    expect(json_decode(json_encode(new SemanticTags(), JSON_THROW_ON_ERROR), true))->toBe([]);
});
