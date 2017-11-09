<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China\Command\Dashboard;

use China\Holiday\HolidayInterface;
use China\Region\Location\AddressInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowRegionCommand extends DashboardCommand
{
    protected static $types = [
        AddressInterface::TYPE_PROVINCE => '省',
        AddressInterface::TYPE_CITY => '市',
        AddressInterface::TYPE_AREA => '区 ',
    ];
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('dashboard:region');
        $this->addOption('parent', 'p', InputOption::VALUE_OPTIONAL);
        $this->setDescription('展示我国省市县信息');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $regionService = $this->getChina()->getRegion();
        $style = new SymfonyStyle($input, $output);
        $headers = ['Code', '名称', '类型'];

        if ($parentName = $input->getOption('parent')) {
            $parent = $regionService->findByName($parentName) ?: $regionService->findByCode($parentName);
            if ($parent === false) {
                throw new \InvalidArgumentException(sprintf('你提供的上级地区“%s”似乎是不存在的', $parentName));
            }
            $regions = $parent->getChildren()->toArray();
        } else {
            $regions = $regionService->getProvinces()->toArray();
        }

        $rows = array_map(function(AddressInterface $address){
            return [
                $address->getCode(),
                "<info>{$address->getName()}</info>",
                static::$types[$address->getType()],
            ];
        }, $regions);
        $style->table($headers, $rows);
    }
}