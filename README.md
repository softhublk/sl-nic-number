# sl-nic-number

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]


Simple package to validate Sri Lankan NIC number



## Install

Via Composer

``` bash
$ composer require softhublk/sl-nic-number
```

## Usage

``` php
<?php
require  'vendor/autoload.php';

use Softhub\SlNicNumber\Nic;

$nic = new Nic('991234567');

if ($nic->isValid){                     //validate nic
    echo ("valid nic <br>");
    echo ("Nic Number : ". $nic->nic . "<br>");                  //convert 12 digit number automatically
    echo ("Gender :" . $nic->getGender() . "<br>");              //get inc owner gender
    echo ("Date Of birth : ". $nic->getBirthDay() . "<br>");     //get owner birthday
}else{
    echo "invalid Nic";
}


```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email avantha.nimna@gmail.com instead of using the issue tracker.

## Credits

- [Nimna Avantha][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/softhublk/sl-nic-number.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/softhublk/sl-nic-number/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/softhublk/sl-nic-number.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/softhublk/sl-nic-number.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/softhublk/sl-nic-number.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/softhublk/sl-nic-number
[link-travis]: https://travis-ci.org/softhublk/sl-nic-number
[link-scrutinizer]: https://scrutinizer-ci.com/g/softhublk/sl-nic-number/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/softhublk/sl-nic-number
[link-downloads]: https://packagist.org/packages/softhublk/sl-nic-number
[link-author]: https://github.com/nimnaherath
[link-contributors]: ../../contributors
