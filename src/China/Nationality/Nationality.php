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

final class Nationality implements NationalityInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $pinyin;

    /**
     * @var number
     */
    protected $population;

    public function __construct(string $name, string $pinyin, int $population)
    {
        $this->name = $name;
        $this->pinyin = $pinyin;
        $this->population = $population;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPinyin(): string
    {
        return $this->pinyin;
    }

    /**
     * {@inheritdoc}
     */
    public function getPopulation(): int
    {
        return $this->population;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'pinyin' => $this->pinyin,
            'population' => $this->population,
        ];
    }
}