<?php

declare(strict_types = 1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\Crc16;
use Arcticfalcon\EmvQr\CrcParams;

class Crc16Test extends TestCase
{
    public function testChecksum()
    {
        $crc = new Crc16(CrcParams::ccittFalse());
        $data = '00020101021143510016com.mercadolibre0127https://mpago.la/pos/41109150150011271284909525204970053030325802AR5920GLADYS MABEL GIMENEZ6011VILLA BOSCH6304';
        $checksum = $crc->hashString($data);

        static::assertEquals('57a8', $checksum);
    }
}
