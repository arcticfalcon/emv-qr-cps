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

declare(strict_types=1);

namespace Arcticfalcon\EmvQr;

use Arcticfalcon\EmvQr\DataObjects\CountryCode;
use Arcticfalcon\EmvQr\DataObjects\GloballyUniqueIdentifier;
use Arcticfalcon\EmvQr\DataObjects\MerchantCategoryCode;
use Arcticfalcon\EmvQr\DataObjects\MerchantCity;
use Arcticfalcon\EmvQr\DataObjects\MerchantName;
use Arcticfalcon\EmvQr\DataObjects\PayloadFormatIndicator;
use Arcticfalcon\EmvQr\DataObjects\PointOfInitializationMethod;
use Arcticfalcon\EmvQr\DataObjects\TransactionCurrency;
use Arcticfalcon\EmvQr\Templates\MerchantAccountInformation;

class EmvQr
{
    public static function basicStaticMerchantPayload(
        string $merchantAccountInformationId,
        string $merchantAccountInformationValue,
        string $merchantCategoryCode,
        string $transactionCurrency,
        string $countryCode,
        string $merchantName,
        string $merchantCity
    ): MerchantPayload {
        $merchantAccountInformation = new MerchantAccountInformation(
            $merchantAccountInformationId,
            new GloballyUniqueIdentifier($merchantAccountInformationValue)
        );

        $merchantPayload = new MerchantPayload(
            new PayloadFormatIndicator(),
            new PointOfInitializationMethod(PointOfInitializationMethod::STATIC),
            $merchantAccountInformation,
            new MerchantCategoryCode($merchantCategoryCode),
            new TransactionCurrency($transactionCurrency),
            null,
            null,
            null,
            null,
            new CountryCode($countryCode),
            new MerchantName($merchantName),
            new MerchantCity($merchantCity),
            null
        );

        return $merchantPayload;
    }
}
