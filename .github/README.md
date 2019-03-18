# arcticfalcon/emv-qr-cps

[![Source Code][badge-source]][source]
[![Latest Version][badge-release]][packagist]
[![Software License][badge-license]][license]
[![PHP Version][badge-php]][php]
[![Build Status][badge-build]][build]
[![Coverage Status][badge-coverage]][coverage]
[![Total Downloads][badge-downloads]][downloads]

EMV QR Code Specification for Payment Systems: Merchant-Presented Mode

This project adheres to a [Contributor Code of Conduct][conduct]. By
participating in this project and its community, you are expected to uphold this
code.

## Possible Problems
* Encoding of unicode characters

## Not implemented
* Numeric character set restriction
* Alphanumeric Special character set restriction
* AdditionalData template
* MerchantInformationLanguage template 
* UnreservedTemplate  template
* Amounts validation

## Installation

The preferred method of installation is via [Composer][]. Run the following
command to install the package and add it as a requirement to your project's
`composer.json`:

```bash
composer require arcticfalcon/emv-qr-cps
```


## Contributing

Contributions are welcome! Please read [CONTRIBUTING][] for details.


## Copyright and License

The arcticfalcon/emv-qr-cps library is copyright © [Juan Falcón](https://github.com/arcticfalcon)
and licensed for use under the MIT License (MIT). Please see [LICENSE][] for
more information.


[conduct]: https://github.com/arcticfalcon/emv-qr-cps/blob/master/.github/CODE_OF_CONDUCT.md
[composer]: http://getcomposer.org/
[documentation]: https://arcticfalcon.github.io/emv-qr-cps/
[contributing]: https://github.com/arcticfalcon/emv-qr-cps/blob/master/.github/CONTRIBUTING.md

[badge-source]: http://img.shields.io/badge/source-arcticfalcon/emv--qr--cps-blue.svg?style=flat-square
[badge-release]: https://img.shields.io/packagist/v/arcticfalcon/emv-qr-cps.svg?style=flat-square&label=release
[badge-license]: https://img.shields.io/packagist/l/arcticfalcon/emv-qr-cps.svg?style=flat-square
[badge-php]: https://img.shields.io/packagist/php-v/arcticfalcon/emv-qr-cps.svg?style=flat-square
[badge-build]: https://img.shields.io/travis/arcticfalcon/emv-qr-cps/master.svg?style=flat-square
[badge-coverage]: https://img.shields.io/coveralls/github/arcticfalcon/emv-qr-cps/master.svg?style=flat-square
[badge-downloads]: https://img.shields.io/packagist/dt/arcticfalcon/emv-qr-cps.svg?style=flat-square&colorB=mediumvioletred

[source]: https://github.com/arcticfalcon/emv-qr-cps
[packagist]: https://packagist.org/packages/arcticfalcon/emv-qr-cps
[license]: https://github.com/arcticfalcon/emv-qr-cps/blob/master/LICENSE
[php]: https://php.net
[build]: https://travis-ci.org/arcticfalcon/emv-qr-cps
[coverage]: https://coveralls.io/r/arcticfalcon/emv-qr-cps?branch=master
[downloads]: https://packagist.org/packages/arcticfalcon/emv-qr-cps
