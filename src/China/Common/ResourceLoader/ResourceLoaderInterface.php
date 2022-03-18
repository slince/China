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

namespace China\Common\ResourceLoader;

use China\Common\ResourceFile;
use Doctrine\Common\Collections\Collection;

interface ResourceLoaderInterface extends Collection
{
    /**
     * 获取资源文件.
     *
     * @return ResourceFile
     */
    public function getResourceFile();

    /**
     * 处理原生数据.
     *
     * @param mixed $data
     *
     * @return array
     */
    public function handleRawData($data);
}