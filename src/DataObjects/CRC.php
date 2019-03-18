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

namespace Arcticfalcon\EmvQr\DataObjects;

use Arcticfalcon\EmvQr\Crc16;
use Arcticfalcon\EmvQr\CrcParams;
use Arcticfalcon\EmvQr\DataObject;

class CRC extends DataObject
{
    public function __construct(string $data)
    {
        $crc = new Crc16(CrcParams::ccittFalse());
        $checksum = $crc->hashString($data . static::getId() . '04');
        if (mb_strlen($checksum) > 4) {
            $checksum = mb_substr($checksum, -4, 4);
        }

        parent::__construct(static::getId(), 4, mb_strtoupper($checksum));
    }

    public static function tryParse(string $data)
    {
        throw new \LogicException();
    }

    public static function getId(): string
    {
        return '63';
    }
}
