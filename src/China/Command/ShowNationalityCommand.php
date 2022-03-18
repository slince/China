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

use China\Nationality\NationalityInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowNationalityCommand extends DashboardCommand
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('dashboard:nationality');
        $this->setDescription('展示民族数据信息');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $nationalityService = $this->getChina()->getNationality();
        $style = new SymfonyStyle($input, $output);
        $headers = ['名称', '拼音', '人口'];

        $nationalities = $nationalityService->findAll()->toArray();
        $rows = array_map(function(NationalityInterface $nationality){
            return [
                "<info>{$nationality->getName()}</info>",
                $nationality->getPinyin(),
                $nationality->getPopulation(),
            ];
        }, $nationalities);
        $style->table($headers, $rows);
    }
}