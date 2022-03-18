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

namespace China\Command;

use China\China;
use Symfony\Component\Console\Command\Command;

class DashboardCommand extends Command
{
    /**
     * @var China
     */
    protected $china;

    /**
     * 获取china对象
     *
     * @return China
     */
    protected function getChina(): China
    {
        if (null === $this->china) {
            $this->china = new China();
        }
        return $this->china;
    }
}