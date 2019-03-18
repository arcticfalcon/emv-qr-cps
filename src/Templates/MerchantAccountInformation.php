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

namespace Arcticfalcon\EmvQr\Templates;

use Arcticfalcon\EmvQr\DataObjects\GloballyUniqueIdentifier;
use Arcticfalcon\EmvQr\DataObjects\PaymentNetworkSpecific;
use Arcticfalcon\EmvQr\EmvQrHelper;
use Arcticfalcon\EmvQr\Template;

class MerchantAccountInformation extends Template
{
    public function __construct(string $id, GloballyUniqueIdentifier $identifier)
    {
        $this->assertPossibleValues(range(26, 51), $id);

        $this->dataObjects = [
            $identifier,
        ];

        parent::__construct($id, 1, ''); // Length and value are dynamically evaluated in Template

        $this->assertValueLength();
    }

    public function addTemplateDataObject(PaymentNetworkSpecific $object)
    {
        $this->dataObjects[] = $object;

        $this->assertValueLength();
    }

    public static function tryParse(string $data)
    {
        $parts = parent::split($data);

        // Parse content
        $subParts = EmvQrHelper::splitCode($parts[2]);

        $gui = GloballyUniqueIdentifier::tryParse($subParts[GloballyUniqueIdentifier::getId()]);
        unset($subParts[GloballyUniqueIdentifier::getId()]);

        // Create instance
        $new = new static($parts[0], $gui);

        // Add additional parts
        foreach ($subParts as $subPart) {
            $pns = PaymentNetworkSpecific::tryParse($subPart);
            if ($pns) {
                $new->addTemplateDataObject($pns);
            }
        }

        return $new;
    }

    public static function getId(): string
    {
        throw new \LogicException();
    }

    public static function matchesId(string $id): bool
    {
        return in_array($id, range(26, 51));
    }

    private function assertValueLength()
    {
        $value = '';
        foreach ($this->dataObjects as $object) {
            $value .= (string) $object;
        }

        $this->assertMaxLength(99, $value);
    }
}
