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
use Arcticfalcon\EmvQr\DataObjects\PostalCode;
use Arcticfalcon\EmvQr\DataObjects\TipOrConvenienceIndicator;
use Arcticfalcon\EmvQr\DataObjects\TransactionAmount;
use Arcticfalcon\EmvQr\DataObjects\TransactionCurrency;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeeFixed;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeePercentage;
use Arcticfalcon\EmvQr\EmvQrException;
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

    public function testExampleB()
    {
        $original = '00020101021143200016com.mercadolibre52049700530303254031185502025602135802AR5903OOM6004LAND610412346304D636';

        $merchantAccountInformation = new MerchantAccountInformation(
            '43',
            new GloballyUniqueIdentifier('com.mercadolibre')
        );

        $merchantPayload = new MerchantPayload(
            new PayloadFormatIndicator(),
            new PointOfInitializationMethod(PointOfInitializationMethod::STATIC),
            $merchantAccountInformation,
            new MerchantCategoryCode('9700'),
            new TransactionCurrency(Iso4217Currency::ARS),
            new TransactionAmount('118'),
            new TipOrConvenienceIndicator(TipOrConvenienceIndicator::FIXED),
            new ValueOfConvenienceFeeFixed('13'),
            null,
            new CountryCode(Iso3166Countries::ARGENTINA),
            new MerchantName('OOM'),
            new MerchantCity('LAND'),
            new PostalCode('1234')
        );

        static::assertEquals($original, (string) $merchantPayload);
    }

    public function testExampleC()
    {
        $original = '00020101021248160012com.whatwhat52049700530318854031185502035702105802AR5903OOM6004LAND6104123463040E47';

        $merchantAccountInformation = new MerchantAccountInformation(
            '48',
            new GloballyUniqueIdentifier('com.whatwhat')
        );

        $merchantPayload = new MerchantPayload(
            new PayloadFormatIndicator(),
            new PointOfInitializationMethod(PointOfInitializationMethod::DYNAMIC),
            $merchantAccountInformation,
            new MerchantCategoryCode('9700'),
            new TransactionCurrency(Iso4217Currency::CRC),
            new TransactionAmount('118'),
            new TipOrConvenienceIndicator(TipOrConvenienceIndicator::PERCENTAGE),
            null,
            new ValueOfConvenienceFeePercentage('10'),
            new CountryCode(Iso3166Countries::ARGENTINA),
            new MerchantName('OOM'),
            new MerchantCity('LAND'),
            new PostalCode('1234')
        );

        static::assertEquals($original, (string) $merchantPayload);
    }

    public function testParse()
    {
        $original = '00020101021143510016com.mercadolibre0127https://mpago.la/pos/41109150150011271284909525204970053030325802AR5920GLADYS MABEL GIMENEZ6011VILLA BOSCH630457A8';
        $qr = MerchantPayload::parse($original);

        static::assertEquals($original, (string) $qr);
    }

    public function testParseB()
    {
        $original = '00020101021143200016com.mercadolibre52049700530303254031185502025602135802AR5903OOM6004LAND610412346304D636';
        $qr = MerchantPayload::parse($original);

        static::assertEquals($original, (string) $qr);
    }

    public function testParseC()
    {
        $original = '00020101021248160012com.whatwhat52049700530318854031185502035702105802AR5903OOM6004LAND6104123463040E47';
        $qr = MerchantPayload::parse($original);

        static::assertEquals($original, (string) $qr);
    }

    public function testGetters()
    {
        $original = '00020101021248160012com.whatwhat52049700530318854031185502035702105802AR5903OOM6004LAND6104123463040E47';
        $qr = MerchantPayload::parse($original);

        $qr->getPayloadFormatIndicator();
        $qr->getPointOfInitializationMethod();
        $qr->getMerchantAccountInformationCollection();
        $qr->getMerchantCategoryCode();
        $qr->getTransactionCurrency();
        $qr->getTransactionAmount();
        $qr->getTipOrConvenienceIndicator();
        $qr->getValueOfConvenienceFeeFixed();
        $qr->getValueOfConvenienceFeePercentage();
        $qr->getCountryCode();
        $qr->getMerchantName();
        $qr->getMerchantCity();
        $qr->getPostalCode();

        static::assertEquals($original, (string) $qr);
    }

    public function testInvalidCode()
    {
        static::expectException(EmvQrException::class);

        $original = '00020101021248160012com.whatwhat52049700530318854031185502035702105802AR5903OOM6004LAND6104123463040E48';
        MerchantPayload::parse($original);
    }

        public function testPayloadTooBig()
    {
        $merchantAccountInformation = new MerchantAccountInformation(
            '43',
            new GloballyUniqueIdentifier('com.mercadolibre')
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
            new MerchantName('aaaaaaaaaaaaaaaaaaaaaaaaa'),
            new MerchantCity('aaaaaaaaaaaaaaa'),
            null
        );


        $info2 = new MerchantAccountInformation(
            '47',
            new GloballyUniqueIdentifier('23423412312371284909522712849095')
        );
        $info2->addTemplateDataObject(new PaymentNetworkSpecific('01', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'));
        $merchantPayload->addMerchantAccountInformation($info2);

        $info3 = new MerchantAccountInformation(
            '48',
            new GloballyUniqueIdentifier('23423412312371284909522712849095')
        );
        $info3->addTemplateDataObject(new PaymentNetworkSpecific('01', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'));
        $merchantPayload->addMerchantAccountInformation($info3);

        $info4 = new MerchantAccountInformation(
            '49',
            new GloballyUniqueIdentifier('23423412312371284909522712849095')
        );
        $info4->addTemplateDataObject(new PaymentNetworkSpecific('01', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'));
        $merchantPayload->addMerchantAccountInformation($info4);

        $info5 = new MerchantAccountInformation(
            '50',
            new GloballyUniqueIdentifier('23423412312371284909522712849095')
        );
        $info5->addTemplateDataObject(new PaymentNetworkSpecific('01', 'bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb'));

        static::expectException(EmvQrException::class);

        $merchantPayload->addMerchantAccountInformation($info5);
    }
}
