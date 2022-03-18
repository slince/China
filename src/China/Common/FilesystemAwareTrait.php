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

namespace China\Common;

use Symfony\Component\Filesystem\Filesystem;

trait FilesystemAwareTrait
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * 设置文件系统
     *
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * 获取文件系统
     *
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }
}