<?php

declare(strict_types = 1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObjects\CountryCode;
use Arcticfalcon\EmvQr\DataObjects\GloballyUniqueIdentifier;
use Arcticfalcon\EmvQr\DataObjects\MerchantCategoryCode;
use Arcticfalcon\EmvQr\DataObjects\MerchantCity;
use Arcticfalcon\EmvQr\DataObjects\MerchantName;
use Arcticfalcon\EmvQr\DataObjects\PayloadFormatIndicator;
use Arcticfalcon\EmvQr\DataObjects\PaymentNetworkSpecific;
use Arcticfalcon\EmvQr\DataObjects\PointOfInitializationMethod;
use Arcticfalcon\EmvQr\DataObjects\TransactionCurrency;
use Arcticfalcon\EmvQr\Iso3166Countries;
use Arcticfalcon\EmvQr\Iso4217Currency;
use Arcticfalcon\EmvQr\MerchantPayload;
use Arcticfalcon\EmvQr\Templates\MerchantAccountInformation;

class MerchantPayloadTest extends TestCase
{
    public function testExampleA()
    {
        $original = '00020101021143510016com.mercadolibre0127https://mpago.la/pos/41109150150011271284909525204970053030325802AR5920GLADYS MABEL GIMENEZ6011VILLA BOSCH630457A8';

        $merchantAccountInformation = new MerchantAccountInformation(
            '43',
            new GloballyUniqueIdentifier('com.mercadolibre')
        );
        $merchantAccountInformation->addTemplateDataObject(new PaymentNetworkSpecific('01', 'https://mpago.la/pos/411091'));

        $merchantAccountSecondInformation = new MerchantAccountInformation(
            '50',
            new GloballyUniqueIdentifier('27128490952')
        );

        $merchantPayload = new MerchantPayload(
            new PayloadFormatIndicator(),
            new PointOfInitializationMethod(PointOfInitializationMethod::STATIC),
            $merchantAccountInformation,
            new MerchantCategoryCode('9700'),
            new TransactionCurrency(Iso4217Currency::ARS),
            null,
            null,
            null,
            null,
            new CountryCode(Iso3166Countries::ARGENTINA),
            new MerchantName('GLADYS MABEL GIMENEZ'),
            new MerchantCity('VILLA BOSCH'),
            null
        );

        $merchantPayload->addMerchantAccountInformation($merchantAccountSecondInformation);


        static::assertEquals($original, (string) $merchantPayload);
    }

    public function testParse()
    {
        $original = '00020101021143510016com.mercadolibre0127https://mpago.la/pos/41109150150011271284909525204970053030325802AR5920GLADYS MABEL GIMENEZ6011VILLA BOSCH630457A8';
        $qr = MerchantPayload::parse($original);

        static::assertEquals($original, (string) $qr);
    }
}
