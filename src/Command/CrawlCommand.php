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
use China\Common\FilesystemAwareTrait;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;

class CrawlCommand extends Command implements FilesystemAwareInterface
{
    use FilesystemAwareTrait;

    /**
     * @var string
     */
    protected $resourceDir;

    /**
     * @var Client
     */
    protected $client;

    public function __construct(string $resourceDir)
    {
        $this->resourceDir = $resourceDir;
        parent::__construct();
    }

    /**
     * Goutte 实例
     * @return Client
     */
    public function getClient(): Client
    {
        if ($this->client) {
            return $this->client;
        }
        return $this->client = new Client();
    }
}