<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\ResourceLoader;

use Slince\Config\Collection;

interface ResourceLoaderInterface
{
    /**
     *
     * @return Collection
     */
    public function parse();
}