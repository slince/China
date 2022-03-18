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

interface HolidayInterface extends \JsonSerializable
{
    /**
     * 节日类型，中国传统节日.
     *
     * @var string
     */
    const TYPE_TRADITIONAL = 'traditional';

    /**
     * 节日类型，中国24节气.
     *
     * @var string
     */
    const TYPE_SOLAR_TERM = 'solar_term';

    /**
     * 节日类型，国际节日.
     *
     * @var string
     */
    const TYPE_INTERNATIONAL = 'international';

    /**
     * 获取名称.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * 获取类型.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * 获取日期
     *
     * @return DateInterface
     */
    public function getDate(): DateInterface;
}