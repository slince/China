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

final class Date implements DateInterface
{
    /**
     * 月.
     *
     * @var int
     */
    protected $month;

    /**
     * 天.
     *
     * @var int
     */
    protected $day;

    public function __construct(int $month, int $day)
    {
        $this->setMonth($month);
        $this->setDay($day);
    }

    /**
     * {@inheritdoc}
     */
    public function getDay(): int
    {
        return $this->day;
    }

    /**
     * {@inheritdoc}
     */
    public function getMonth(): int
    {
        return $this->month;
    }

    /**
     * {@inheritdoc}
     */
    public function format(string $format): string
    {
        return str_replace(['{month}', '{day}',], [
            $this->month,
            $this->day,
        ], $format);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return $this->format('{month}月{day}日');
    }

    /**
     * 字符串输出.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    protected function setMonth(int $month)
    {
        if (!is_numeric($month) || $month < 1 || $month > 12) {
            throw new \InvalidArgumentException(sprintf('Wrong month, given "%s"', $month));
        }
        $this->month = $month;
    }

    protected function setDay($day)
    {
        if (!is_numeric($day) || $day < 1 || $day > 31) {
            throw new \InvalidArgumentException(sprintf('Wrong day, given "%s"', $day));
        }
        $this->day = $day;
    }
}