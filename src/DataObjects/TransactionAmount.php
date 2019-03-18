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

use Arcticfalcon\EmvQr\DataObject;

class TransactionAmount extends DataObject
{
    public function __construct(string $value)
    {
        $this->assertMaxLength(13, $value);

        parent::__construct(static::getStaticId(), strlen($value), $value);
    }

    public static function tryParse(string $data)
    {
        $parts = parent::split($data);

        if ($parts[0] === static::getStaticId()) {
            return new static($parts[2]);
        }

        return null;
    }

    public static function getStaticId(): string
    {
        return '54';
    }
}
