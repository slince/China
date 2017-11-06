<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace China\Region\Location;

use Doctrine\Common\Collections\Collection;

abstract class Address implements AddressInterface
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var AddressInterface
     */
    protected $parent;

    /**
     * 子地区
     * @var AddressInterface[]|Collection
     */
    protected $children;

    public function __construct($code, $name, AddressInterface $parent = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->parent = $parent;
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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(AddressInterface $parent)
    {
        $this->parent = $parent;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
            'children' => $this->getChildren()
        ];
    }
}