<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\EmvQrException;

class DataObjectTest extends TestCase
{
    public function testGetters()
    {
        $data = new DataObjectStub('00', 4, 'ABCD');

        static::assertEquals('00', $data->getId());
        static::assertEquals(4, $data->getLength());
        static::assertEquals('ABCD', $data->getValue());
    }

    public function testShortLength()
    {
        static::expectException(EmvQrException::class);

        $data = new DataObjectStub('00', 0, 'ABCD');
    }

    public function testLongLength()
    {
        static::expectException(EmvQrException::class);

        $data = new DataObjectStub('00', 100, 'ABCD');
    }

    public function testMatchesId()
    {
        static::assertEquals(true, DataObjectStub::matchesId(DataObjectStub::getStaticId()));
    }

    public function testInvalidValueLength()
    {
        static::expectException(EmvQrException::class);

        $data = new DataObjectStub('00', 4, 'ABCD');

        $data->assert(1, 2, [], 'foo');
    }

    public function testInvalidValueMaxLength()
    {
        static::expectException(EmvQrException::class);

        $data = new DataObjectStub('00', 4, 'ABCD');

        $data->assert(3, 2, [], 'foo');
    }
    
    public function testInvalidValue()
    {
        static::expectException(EmvQrException::class);

        $data = new DataObjectStub('00', 4, 'ABCD');

        $data->assert(3, 3, ['bar'], 'foo');
    }
}
