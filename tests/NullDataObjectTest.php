<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObjects\NullDataObject;

class NullDataObjectTest extends TestCase
{
    public function testInvalidStaticIdCall()
    {
        static::expectException(\LogicException::class);

        NullDataObject::getStaticId();
    }

    public function testInvalidParseCall()
    {
        static::expectException(\LogicException::class);

        NullDataObject::tryParse('');
    }
}
