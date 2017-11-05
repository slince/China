<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Common;

use Symfony\Component\Filesystem\Filesystem;

interface FilesystemAwareInterface
{
    /**
     * 获取文件系统
     * @return Filesystem
     */
    public function getFilesystem();
}