<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Region;

use China\Common\ResourceFile;
use Doctrine\Common\Collections\Collection;

class RegionService implements RegionServiceInterface
{
    /**
     * @var RegionServiceInterface[]|Collection
     */
    protected $regions;

    public function __construct(ResourceFile $resourceFile)
    {
        $this->regions = new RegionLoader($resourceFile);
    }
}