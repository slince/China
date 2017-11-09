<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Holiday;

interface DateInterface extends \JsonSerializable
{
    /**
     * 获取天.
     *
     * @return int
     */
    public function getDay();

    /**
     * 获取month.
     *
     * @return int
     */
    public function getMonth();

    /**
     * 设置天.
     *
     * @throws \InvalidArgumentException
     *
     * @param int $day
     */
    public function setDay($day);

    /**
     * 设置月份.
     *
     * @throws \InvalidArgumentException
     *
     * @param int $month
     */
    public function setMonth($month);

    /**
     * 转换成字符串表达式.
     *
     * @return string
     */
    public function toString();

    /**
     * 格式化输出日期
     *
     * @param string $format
     *
     * @return string
     */
    public function format($format);
}