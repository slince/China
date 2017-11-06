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

abstract class Address implements AddressInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var AddressInterface
     */
    protected $parent;

    public function __construct($name, AddressInterface $parent = null)
    {
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
    public function __toString()
    {
        return $this->getName();
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
    public function jsonSerialize()
    {
        return $this->getName();
    }
}