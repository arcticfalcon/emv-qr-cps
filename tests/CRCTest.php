<?php

declare(strict_types=1);

namespace Arcticfalcon\EmvQr\Test;

use Arcticfalcon\EmvQr\DataObjects\CRC;

class CRCTest extends TestCase
{
    public function testInvalidParseCall()
    {
        static::expectException(\LogicException::class);

        CRC::tryParse('');
    }
}
