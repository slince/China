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

interface IDCardInterface
{
    /**
     * 转换成字符串.
     *
     * @return string
     */
    public function __toString();

    /**
     * 是否是短位身份证
     *
     * @return boolean
     */
    public function isShortLength();

    /**
     * 获取长数字.
     *
     * @return number
     */
    public function getLongNumber();
}