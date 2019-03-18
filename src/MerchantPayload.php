<?php
/**
 * This file is part of the arcticfalcon/emv-qr-cps library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright Copyright (c) Juan Falcón <jcfalcon@gmail.com>
 * @license http://opensource.org/licenses/MIT MIT
 */

declare(strict_types = 1);

namespace Arcticfalcon\EmvQr;

use Arcticfalcon\EmvQr\DataObjects\CountryCode;
use Arcticfalcon\EmvQr\DataObjects\CRC;
use Arcticfalcon\EmvQr\DataObjects\MerchantCategoryCode;
use Arcticfalcon\EmvQr\DataObjects\MerchantCity;
use Arcticfalcon\EmvQr\DataObjects\MerchantName;
use Arcticfalcon\EmvQr\DataObjects\NullDataObject;
use Arcticfalcon\EmvQr\DataObjects\PayloadFormatIndicator;
use Arcticfalcon\EmvQr\DataObjects\PointOfInitializationMethod;
use Arcticfalcon\EmvQr\DataObjects\PostalCode;
use Arcticfalcon\EmvQr\DataObjects\TipOrConvenienceIndicator;
use Arcticfalcon\EmvQr\DataObjects\TransactionAmount;
use Arcticfalcon\EmvQr\DataObjects\TransactionCurrency;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeeFixed;
use Arcticfalcon\EmvQr\DataObjects\ValueOfConvenienceFeePercentage;
use Arcticfalcon\EmvQr\Templates\MerchantAccountInformation;

class MerchantPayload
{
    /** @var PayloadFormatIndicator */
    private $payloadFormatIndicator;

    /** @var PointOfInitializationMethod */
    private $pointOfInitializationMethod;

    /** @var MerchantAccountInformation[] */
    private $merchantAccountInformationCollection;

    /** @var MerchantCategoryCode */
    private $merchantCategoryCode;

    /** @var TransactionCurrency */
    private $transactionCurrency;

    /** @var TransactionAmount|NullDataObject */
    private $transactionAmount;

    /** @var TipOrConvenienceIndicator|NullDataObject */
    private $tipOrConvenienceIndicator;

    /** @var ValueOfConvenienceFeeFixed|NullDataObject */
    private $valueOfConvenienceFeeFixed;

    /** @var ValueOfConvenienceFeePercentage|NullDataObject */
    private $valueOfConvenienceFeePercentage;

    /** @var CountryCode */
    private $countryCode;

    /** @var MerchantName */
    private $merchantName;

    /** @var MerchantCity */
    private $merchantCity;

    /** @var PostalCode|NullDataObject */
    private $postalCode;

    /** @var Template|NullDataObject */
    private $additionalData;

    /** @var Template|NullDataObject */
    private $merchantInformationLanguage;

    /** @var Template|NullDataObject */
    private $unreservedTemplate;

    public function __construct(
        PayloadFormatIndicator $payloadFormatIndicator,
        PointOfInitializationMethod $pointOfInitializationMethod,
        MerchantAccountInformation $merchantAccountInformation,
        MerchantCategoryCode $merchantCategoryCode,
        TransactionCurrency $transactionCurrency,
        TransactionAmount $transactionAmount = null,
        TipOrConvenienceIndicator $tipOrConvenienceIndicator = null,
        ValueOfConvenienceFeeFixed $valueOfConvenienceFeeFixed = null,
        ValueOfConvenienceFeePercentage $valueOfConvenienceFeePercentage = null,
        CountryCode $countryCode,
        MerchantName $merchantName,
        MerchantCity $merchantCity,
        PostalCode $postalCode = null,
        Template $additionalData = null,
        Template $merchantInformationLanguage = null,
        Template $unreservedTemplate = null
    ) {
        $this->payloadFormatIndicator = $payloadFormatIndicator;
        $this->pointOfInitializationMethod = $pointOfInitializationMethod;
        $this->merchantAccountInformationCollection = [$merchantAccountInformation];
        $this->merchantCategoryCode = $merchantCategoryCode;
        $this->transactionCurrency = $transactionCurrency;
        $this->transactionAmount = $transactionAmount ?? new NullDataObject();
        $this->tipOrConvenienceIndicator = $tipOrConvenienceIndicator ?? new NullDataObject();
        $this->valueOfConvenienceFeeFixed = $valueOfConvenienceFeeFixed ?? new NullDataObject();
        $this->valueOfConvenienceFeePercentage = $valueOfConvenienceFeePercentage ?? new NullDataObject();
        $this->countryCode = $countryCode;
        $this->merchantName = $merchantName;
        $this->merchantCity = $merchantCity;
        $this->postalCode = $postalCode ?? new NullDataObject();
        $this->additionalData = $additionalData ?? new NullDataObject();
        $this->merchantInformationLanguage = $merchantInformationLanguage ?? new NullDataObject();
        $this->unreservedTemplate = $unreservedTemplate ?? new NullDataObject();

        // ToDo: validate conditionals

        $this->assertTotalLength();
    }

    public function __toString()
    {
        $merchantAccountInformation = array_map(
            function (MerchantAccountInformation $information) {
                return (string) $information;
            },
            $this->merchantAccountInformationCollection
        );

        $data =
            (string) $this->payloadFormatIndicator .
            (string) $this->pointOfInitializationMethod .
            implode('', $merchantAccountInformation) .
            (string) $this->merchantCategoryCode .
            (string) $this->transactionCurrency .
            (string) $this->transactionAmount .
            (string) $this->tipOrConvenienceIndicator .
            (string) $this->valueOfConvenienceFeeFixed .
            (string) $this->valueOfConvenienceFeePercentage .
            (string) $this->countryCode .
            (string) $this->merchantName .
            (string) $this->merchantCity .
            (string) $this->postalCode .
            (string) $this->additionalData .
            (string) $this->merchantInformationLanguage .
            (string) $this->unreservedTemplate;

        $crc = new CRC($data);

        return $data . (string) $crc;
    }

    public function addMerchantAccountInformation(MerchantAccountInformation $information)
    {
        $this->merchantAccountInformationCollection[] = $information;

        $this->assertTotalLength();
    }

    public static function parse(string $data)
    {
        $parts = EmvQrHelper::splitCode($data);

        $reflection = new \ReflectionClass(static::class);
        /** @var MerchantPayload $new */
        $new = $reflection->newInstanceWithoutConstructor();

        $new->payloadFormatIndicator = PayloadFormatIndicator::tryParse($parts[PayloadFormatIndicator::getId()]);
        $new->pointOfInitializationMethod = PointOfInitializationMethod::tryParse($parts[PointOfInitializationMethod::getId()]);
        $new->merchantCategoryCode = MerchantCategoryCode::tryParse($parts[MerchantCategoryCode::getId()]);
        $new->transactionCurrency = TransactionCurrency::tryParse($parts[TransactionCurrency::getId()]);
        $new->transactionAmount = isset($parts[TransactionAmount::getId()]) ? TransactionAmount::tryParse($parts[TransactionAmount::getId()]) : null;
        $new->tipOrConvenienceIndicator = isset($parts[TipOrConvenienceIndicator::getId()]) ? TipOrConvenienceIndicator::tryParse($parts[TipOrConvenienceIndicator::getId()]) : null;
        $new->valueOfConvenienceFeeFixed = isset($parts[ValueOfConvenienceFeeFixed::getId()]) ? ValueOfConvenienceFeeFixed::tryParse($parts[ValueOfConvenienceFeeFixed::getId()]) : null;
        $new->valueOfConvenienceFeePercentage = isset($parts[ValueOfConvenienceFeePercentage::getId()]) ? ValueOfConvenienceFeePercentage::tryParse($parts[ValueOfConvenienceFeePercentage::getId()]) : null;
        $new->countryCode = CountryCode::tryParse($parts[CountryCode::getId()]);
        $new->merchantName = MerchantName::tryParse($parts[MerchantName::getId()]);
        $new->merchantCity = MerchantCity::tryParse($parts[MerchantCity::getId()]);
        $new->postalCode = isset($parts[PostalCode::getId()]) ? PostalCode::tryParse($parts[PostalCode::getId()]) : null;

        foreach ($parts as $id => $part) {
            if (MerchantAccountInformation::matchesId((string) $id)) {
                $new->addMerchantAccountInformation(MerchantAccountInformation::tryParse($part));
            }
        }

        // ToDo: implement missing parts
//        $this->additionalData
//        $this->merchantInformationLanguage
//        $this->unreservedTemplate

        // Validate:
        if ((string) $new !== $data) {
            throw new EmvQrException('Data may not be valid');
        }

        return $new;
    }

    private function assertTotalLength()
    {
        if (mb_strlen($this->__toString()) > 512) {
            throw new EmvQrException('Length of payload exceeded');
        }
    }

    public function getPayloadFormatIndicator(): PayloadFormatIndicator
    {
        return $this->payloadFormatIndicator;
    }

    public function getPointOfInitializationMethod(): PointOfInitializationMethod
    {
        return $this->pointOfInitializationMethod;
    }

    public function getMerchantAccountInformationCollection(): array
    {
        return $this->merchantAccountInformationCollection;
    }

    public function getMerchantCategoryCode(): MerchantCategoryCode
    {
        return $this->merchantCategoryCode;
    }

    public function getTransactionCurrency(): TransactionCurrency
    {
        return $this->transactionCurrency;
    }

    public function getTransactionAmount()
    {
        return $this->transactionAmount;
    }

    public function getTipOrConvenienceIndicator()
    {
        return $this->tipOrConvenienceIndicator;
    }

    public function getValueOfConvenienceFeeFixed()
    {
        return $this->valueOfConvenienceFeeFixed;
    }

    public function getValueOfConvenienceFeePercentage()
    {
        return $this->valueOfConvenienceFeePercentage;
    }

    public function getCountryCode(): CountryCode
    {
        return $this->countryCode;
    }

    public function getMerchantName(): MerchantName
    {
        return $this->merchantName;
    }

    public function getMerchantCity(): MerchantCity
    {
        return $this->merchantCity;
    }

    public function getPostalCode()
    {
        return $this->postalCode;
    }
}
