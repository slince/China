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

use Doctrine\Common\Collections\Collection;

interface NationalityServiceInterface
{
    /**
     * 获取所有的节假日.
     *
     * @return Collection
     */
    public function findAll();

    /**
     * 查找指定的民族.
     *
     * @param string $name
     *
     * @return NationalityInterface
     */
    public function find($name);
}