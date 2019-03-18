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

abstract class DataObject
{
    /** @var string */
    protected $id;
    /** @var int */
    protected $length;
    /** @var string */
    protected $value;

    public function __construct(string $id, int $length, string $value)
    {
        $this->assertMaxLength(99, $value);
        if ($length < 1 || $length > 99) {
            throw new EmvQrException('Invalid DataObject length: ' . $length);
        }

        $this->id = $id;
        $this->length = $length;
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->id . sprintf('%02d', $this->length) . $this->value;
    }

    abstract public static function tryParse(string $data);

    abstract public static function getStaticId(): string;

    public static function matchesId(string $id): bool
    {
        return static::getStaticId() === $id;
    }

    protected static function split(string $data): array
    {
        return [
            mb_substr($data, 0, 2),
            mb_substr($data, 2, 2),
            mb_substr($data, 4),
        ];
    }

    protected function assertLength(int $length, string $value)
    {
        if (strlen($value) !== $length) {
            throw new EmvQrException('Invalid DataObject value length: ' . $value);
        }
    }

    protected function assertMaxLength(int $maxLength, string $value)
    {
        if (strlen($value) > $maxLength) {
            throw new EmvQrException('Invalid DataObject value length: ' . $value);
        }
    }

    protected function assertPossibleValues(array $possible, string $value)
    {
        if (! in_array($value, $possible)) {
            throw new EmvQrException('Invalid DataObject possible value: ' . $value);
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
