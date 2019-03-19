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

class PaymentNetworkSpecific extends DataObject
{
    public function __construct(string $id, string $value)
    {
        $this->assertPossibleValues(range(1, 99), $id);

        parent::__construct($id, strlen($value), $value);
    }

    public static function tryParse(string $data)
    {
        try {
            $parts = parent::split($data);

            return new static($parts[0], $parts[2]);
        }
        catch (\Exception $exception){
            return null;
        }
    }

    public static function getStaticId(): string
    {
        throw new \LogicException();
    }

    public static function matchesId(string $id): bool
    {
        return in_array($id, range(1, 99));
    }
}
