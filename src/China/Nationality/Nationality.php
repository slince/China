<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Nationality;


class Nationality implements NationalityInterface
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

    public function __construct($name, $pinyin, $population)
    {
        $this->name = $name;
        $this->pinyin = $pinyin;
        $this->population = $population;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getPinyin()
    {
        return $this->pinyin;
    }

    /**
     * {@inheritdoc}
     */
    public function getPopulation()
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
            'population' => $this->population
        ];
    }
}