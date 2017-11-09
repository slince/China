<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Common\ResourceLoader;

use China\Common\ResourceFile;
use Doctrine\Common\Collections\AbstractLazyCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Slince\Config\Config;

class LazyLoader extends AbstractLazyCollection implements ResourceLoaderInterface
{
    /**
     * @var ResourceFile
     */
    protected $resourceFile;

    public function __construct(ResourceFile $resourceFile)
    {
        $this->resourceFile = $resourceFile;
    }

    /**
     * {@inheritdoc}
     */
    public function getResourceFile()
    {
        return $this->resourceFile;
    }

    /**
     * {@inheritdoc}
     */
    public function doInitialize()
    {
        $rawData = (new Config($this->resourceFile->getPathname()))->toArray();
        $this->collection = new ArrayCollection($this->handleRawData($rawData));
    }

    /**
     * {@inheritdoc}
     */
    public function handleRawData($data)
    {
        return $data;
    }
}