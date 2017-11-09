<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Command;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Filesystem\Filesystem;

class Application extends BaseApplication
{
    public function __construct()
    {
        parent::__construct('China');
    }

    public function getDefaultCommands()
    {
        $filesystem = new Filesystem();

        return array_merge(parent::getDefaultCommands(), [
            new GetHolidayCommand($filesystem),
            new GetNationalityCommand($filesystem),
            new GetRegionCommand($filesystem),
            new Dashboard\ShowHolidayCommand(),
            new Dashboard\ShowNationalityCommand(),
        ]);
    }
}