<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\EmvQr;
use Arcticfalcon\EmvQr\Iso3166Countries;
use Arcticfalcon\EmvQr\Iso4217Currency;

class EmvQrTest extends TestCase
{
    public function testExampleA()
    {
        $original = '00020101021143200016com.mercadolibre5204970053030325802AR5920GLADYS MABEL GIMENEZ6011VILLA BOSCH6304ADEB';

        $payload = EmvQr::basicStaticMerchantPayload(
            '43',
            'com.mercadolibre',
            '9700',
            Iso4217Currency::ARS,
            Iso3166Countries::ARGENTINA,
            'GLADYS MABEL GIMENEZ',
            'VILLA BOSCH'
        );

        static::assertEquals($original, (string)$payload);
    }
}
