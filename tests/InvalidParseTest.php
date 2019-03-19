<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObjects\CountryCode;
use Arcticfalcon\EmvQr\DataObjects\GloballyUniqueIdentifier;
use Arcticfalcon\EmvQr\DataObjects\MerchantCategoryCode;
use Arcticfalcon\EmvQr\DataObjects\MerchantCity;
use Arcticfalcon\EmvQr\DataObjects\MerchantName;
use Arcticfalcon\EmvQr\DataObjects\PayloadFormatIndicator;
use Arcticfalcon\EmvQr\DataObjects\PaymentNetworkSpecific;
use Arcticfalcon\EmvQr\DataObjects\PointOfInitializationMethod;
use Arcticfalcon\EmvQr\DataObjects\PostalCode;
use Arcticfalcon\EmvQr\DataObjects\TipOrConvenienceIndicator;
use Arcticfalcon\EmvQr\DataObjects\TransactionAmount;
use Arcticfalcon\EmvQr\DataObjects\TransactionCurrency;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeeFixed;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeePercentage;
use Arcticfalcon\EmvQr\Templates\MerchantAccountInformation;

class InvalidParseTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testInvalidParseCall($class)
    {
        $null = $class::tryParse('');

        static::assertNull($null);
    }

    public function additionProvider()
    {
        return [
            [CountryCode::class],
            [GloballyUniqueIdentifier::class],
            [MerchantCategoryCode::class],
            [MerchantCity::class],
            [MerchantName::class],
            [PayloadFormatIndicator::class],
            [PaymentNetworkSpecific::class],
            [PointOfInitializationMethod::class],
            [PostalCode::class],
            [TipOrConvenienceIndicator::class],
            [TransactionAmount::class],
            [TransactionCurrency::class],
            [ValueOfConvenienceFeeFixed::class],
            [ValueOfConvenienceFeePercentage::class],
            [MerchantAccountInformation::class],
        ];
    }
}
