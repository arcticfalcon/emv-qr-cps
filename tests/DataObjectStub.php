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

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObject;

class DataObjectStub extends DataObject
{
    public function assert(int $length, int $maxLength, array $possible, string $value)
    {
        $this->assertLength($length, $value);
        $this->assertMaxLength($maxLength, $value);
        $this->assertPossibleValues($possible, $value);
    }

    public static function tryParse(string $data)
    {
    }

    public static function getStaticId(): string
    {
        return 'DataObjectStub';
    }
}
