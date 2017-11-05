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


class Date implements DateInterface
{
    /**
     * 天
     * @var int
     */
    protected $day;

    /**
     * 月
     * @var int
     */
    protected $month;

    public function __construct($month, $day)
    {
        $this->month = $month;
        $this->day = $day;
    }

    /**
     * {@inheritdoc}
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * {@inheritdoc}
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * {@inheritdoc}
     */
    public function setMonth($month)
    {
        if (!is_numeric($month) || $month < 1 && $month > 12) {
            throw new \InvalidArgumentException(sprintf('Wrong month, given "%s"', $month));
        }
        $this->month = $month;
    }

    /**
     * {@inheritdoc}
     */
    public function setDay($day)
    {
        if (!is_numeric($day) || $day < 1 && $day > 31) {
            throw new \InvalidArgumentException(sprintf('Wrong day, given "%s"', $day));
        }
        $this->day = $day;
    }

    /**
     * {@inheritdoc}
     */
    public function format($format)
    {
        return str_replace([
            '{month}',
            '{day}'
        ], [
            $this->month,
            $this->day
        ], $format);
    }

    /**
     * {@inheritdoc}
     */
    public function toString()
    {
        return $this->format('{month}月{day}日');
    }

    /**
     * 字符串输出
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
}