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

use China\Common\ResourceFile;
use Doctrine\Common\Collections\Collection;

class NationalityService implements NationalityServiceInterface
{
    /**
     * @var Collection
     */
    protected $nationalities;

    public function __construct(ResourceFile $resourceFile)
    {
        $this->nationalities = new NationalityLoader($resourceFile);
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        return $this->nationalities;
    }

    /**
     * {@inheritdoc}
     */
    public function find($name)
    {
        return $this->nationalities->filter(function(NationalityInterface $nationality) use ($name){
            return $nationality->getName() === $name;
        })->first();
    }
}