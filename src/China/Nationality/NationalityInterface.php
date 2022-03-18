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

namespace China\Nationality;

interface NationalityInterface extends \JsonSerializable
{
    /**
     * 民族名称
     * @return string
     */
    public function getName(): string;

    /**
     * 民族拼音
     * @return string
     */
    public function getPinyin(): string;

    /**
     * 人口数量
     * @return int
     */
    public function getPopulation(): int;
}