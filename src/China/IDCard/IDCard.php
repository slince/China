<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\IDCard;

class IDCard implements IDCardInterface
{
    /**
     * 身份证数字
     * @var number
     */
    protected $id;

    public function __construct($id)
    {
        static::assertValidIDCard($id);
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function isShortLength()
    {
        return strlen($this->id) === 15;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongNumber()
    {
        $id = $this->id;
        if ($this->isShortLength()) {
            $id = IDCardUtils::convertIDCard15to18($this->id);
        }
        return $id;
    }

    /**
     * 身份证是否合法
     * @param string $id
     */
    public static function assertValidIDCard($id)
    {
        if (!is_numeric($id)) {
            throw new \InvalidArgumentException(sprintf('The id "%s" card contains the non-numeric characters', $id));
        }
        $length = strlen($id);
        if ($length !== 15 && $length !== 18) {
            throw new \InvalidArgumentException(sprintf('The id "%s" card length should be 15 numbers or 18 numbers, given %d', $id, $length));
        }
        $convertedId = $id;
        if ($length === 15) {
            $convertedId = IDCardUtils::convertIDCard15to18($id);
        }
        if (!IDCardUtils::check18IDCard($convertedId)) {
            throw new \InvalidArgumentException(sprintf('The Id card "%s" is invalid',  $id));
        }
    }
}