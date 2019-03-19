<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObjects\PaymentNetworkSpecific;
use Arcticfalcon\EmvQr\EmvQrException;

class PaymentNetworkSpecificTest extends TestCase
{
    public function testInvalidId()
    {
        static::expectException(EmvQrException::class);

        new PaymentNetworkSpecific('00', 'foobar');
    }

    public function testInvalidId2()
    {
        static::expectException(EmvQrException::class);

        new PaymentNetworkSpecific('100', 'foobar');
    }

    public function testInvalidStaticIdCall()
    {
        static::expectException(\LogicException::class);

        PaymentNetworkSpecific::getStaticId();
    }
}
