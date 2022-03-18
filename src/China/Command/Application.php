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

use China\Common\FilesystemAwareInterface;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Filesystem\Filesystem;

final class Application extends BaseApplication
{
    /**
     * @var string
     */
    protected $resourceDir;

    public function __construct(string $resourceDir)
    {
        $this->resourceDir = $resourceDir;
        parent::__construct('China');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands(): array
    {
        return array_merge(parent::getDefaultCommands(), $this->createCommands());
    }

    protected function createCommands(): array
    {
        $commands = [
            new CrawlHolidayCommand($this->resourceDir),
            new CrawlNationalityCommand($this->resourceDir),
            new CrawlRegionCommand($this->resourceDir),
            new ShowHolidayCommand(),
            new ShowNationalityCommand(),
            new ShowRegionCommand(),
        ];
        $filesystem = new Filesystem();
        foreach ($commands as $command) {
            if ($command instanceof FilesystemAwareInterface) {
                $command->setFilesystem($filesystem);
            }
        }
        return $commands;
    }
}