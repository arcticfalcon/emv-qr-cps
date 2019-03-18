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

abstract class Template extends DataObject
{
    /** @var DataObject[] */
    protected $dataObjects;

    public function __toString()
    {
        $value = '';
        foreach ($this->dataObjects as $object) {
            $value .= (string) $object;
        }

        return $this->id . sprintf('%02d', strlen($value)) . $value;
    }

    public function getDataObjects(): array
    {
        return $this->dataObjects;
    }
}
