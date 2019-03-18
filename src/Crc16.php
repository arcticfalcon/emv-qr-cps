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

class Crc16
{
    /**
     * @var CrcParams
     */
    private $crcParams;

    public function __construct(CrcParams $crcParams)
    {
        $this->crcParams = $crcParams;
    }

    /**
     * Returns Hexadecimal representation.
     */
    public function hashString(string $data): string
    {
        return dechex($this->hashBytes(unpack('C*', $data)));
    }

    public function hashBytes(array $data)
    {
        if ($this->crcParams->RefIn) {
            $crc = $this->crcParams->InvertedInit;
        } else {
            $crc = $this->crcParams->Init;
        }
        if ($this->crcParams->RefOut) {
            foreach ($data as $d) {
                $crc = $this->crcParams->Array[($d ^ $crc) & 0xFF] ^ ($crc >> 8 & 0xFF);
            }
        } else {
            foreach ($data as $d) {
                $crc = $this->crcParams->Array[(($crc >> 8) ^ $d) & 0xFF] ^ ($crc << 8);
            }
        }
        $crc = $crc ^ $this->crcParams->XorOut;

        return $crc & 0xFFFF;
    }
}
