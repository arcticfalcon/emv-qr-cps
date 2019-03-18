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

class EmvQrHelper
{
    public static function splitCode(string $code): array
    {
        $parts = [];
        $length = strlen($code);
        for ($i = 0; $i < $length;) {
            $partLength = (int) substr($code, $i + 2, 2);
            $parts[substr($code, $i, 2)] = substr($code, $i, 4 + $partLength);
            $i += 4 + $partLength;
        }

        return $parts;
    }
}
