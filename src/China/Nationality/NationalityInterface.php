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

interface NationalityInterface extends \JsonSerializable
{
    public function getName();

    public function getPinyin();

    public function getPopulation();
}