<?php

declare(strict_types=1);

/*
 * This file is part of the slince/china package.
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
    public function getDay(): int;

    /**
     * 获取month.
     *
     * @return int
     */
    public function getMonth(): int;

    /**
     * 转换成字符串表达式.
     *
     * @return string
     */
    public function toString(): string;

    /**
     * 格式化输出日期
     *
     * @param string $format
     *
     * @return string
     */
    public function format(string $format): string;
}