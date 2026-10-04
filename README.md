<a href="https://bas.dev">
    <img src="https://bmcdn.nl/assets/branding/logo.svg" alt="Bas Milius" height="48" />
</a>

---

# Raxos Wallet

Build, sign and package Apple Wallet passes and pass bundles.

[Documentation](https://raxos.dev/wallet/) | [Packagist](https://packagist.org/packages/raxos/wallet) | [Raxos](https://github.com/basmilius/raxos)

- Typed pass models for generic passes, store cards, coupons, tickets and boarding passes.
- Fields, barcodes, colors, locations, localization and semantic tags.
- Signed `.pkpass` archives, `.pkpasses` bundles and HTTP responses.

## Installation

Requires PHP 8.5 or later. Enable the `json`, `openssl`, `zip` PHP extensions. Composer checks the remaining package and extension dependencies declared in [composer.json](composer.json).

```sh
composer require "raxos/wallet:^3.3"
```

## Usage

```php
<?php
declare(strict_types=1);

use Raxos\Wallet\Apple\Component\EventTicket;
use Raxos\Wallet\Apple\Component\Pass;
use Raxos\Wallet\Apple\Component\PrimaryField;
use Raxos\Wallet\Apple\Identity;
use Raxos\Wallet\Apple\PKPass;

require __DIR__ . '/vendor/autoload.php';

$pass = new Pass(
    description: 'Admission ticket',
    organizationName: 'Example Venue',
    serialNumber: 'TICKET-0042',
    eventTicket: new EventTicket(
        primaryFields: [new PrimaryField(key: 'event', value: 'Summer Concert', label: 'Event')]
    )
);

function packagePass(Identity $identity, Pass $pass, string $iconPath): PKPass
{
    $archive = new PKPass($identity, $pass);
    $archive->file('icon.png', $iconPath);
    $archive->sign();
    $archive->close();

    return $archive;
}
```

Create an `Identity` from your Apple pass signing certificate, private key, key password, pass type identifier and team identifier, then call `packagePass()` with the required icon asset. The WWDR certificate is included in the package. Read the result with `binary()` or serve it with `respond()->send()`, then call `delete()` to remove the temporary archive. The current implementation supports Apple Wallet.

## Documentation

- [Building a pass](https://raxos.dev/wallet/pass-structure)
- [Fields, barcodes and components](https://raxos.dev/wallet/fields-and-components)
- [Signing and packaging](https://raxos.dev/wallet/signing-and-packaging)
- [Bundles and localization](https://raxos.dev/wallet/bundles-and-localization)

## Testing

Run this library's Pest suite from the Raxos workspace:

```sh
git clone --recurse-submodules https://github.com/basmilius/raxos.git
cd raxos
composer install
vendor/bin/pest --testsuite=wallet
```

See [Testing Raxos](https://github.com/basmilius/raxos/blob/main/TESTING.md) for PHP extensions, integration services and coverage commands. The library's [Tests workflow](.github/workflows/tests.yml) also runs in GitHub Actions.

## License

[MIT](LICENSE). Copyright (c) 2017 - present Bas Milius.
