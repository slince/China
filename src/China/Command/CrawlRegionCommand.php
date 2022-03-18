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

use China\Common\Utils;
use China\Region\Location\AddressInterface;
use China\Region\Location\District;
use China\Region\Location\City;
use China\Region\Location\Province;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class CrawlRegionCommand extends CrawlCommand
{
    /**
     * 资源地址
     *
     * @var string
     */
    const URL = 'http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/201703/t20170310_1471429.html';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('crawl:region');
        $this->setDescription('从国家统计局采集地区信息');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = $this->resourceDir.'/regions/regions.json';

        $crawler = $this->getClient()->request('GET', static::URL);

        $regions = $crawler->filter('p.MsoNormal')->each(function(Crawler $node) use (&$provinces, &$cities, &$areas){
            $code = $node->filter('span[lang="EN-US"]')->text();
            $name = $node->filter('span[style]')->last()->text();

            return [
                'code' => preg_replace('/[^\d]/', '', $code),
                'name' => Utils::clearBlankCharacters($name),
            ];
        });
        //归类数据
        list($provinces, $cities, $areas) = $this->organizeRegions($regions);
        //构建树形结构
        $root = new Province(0, null);
        $root->shortCode = 0;
        $this->buildRegionsTree(array_merge($provinces, $cities, $areas), $root);

        $this->filesystem->dumpFile($this->resourceDir.'/regions/provinces.json', \json_encode($this->extractAddressesWithoutChildren($provinces), JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile($this->resourceDir.'/regions/cities.json', \json_encode($this->extractAddressesWithoutChildren($cities), JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile($this->resourceDir.'/regions/districts.json', \json_encode($this->extractAddressesWithoutChildren($areas), JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile($outputFile, \json_encode($root->getChildren(), JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
    }

    /**
     * 提取省份数据，去除子地区数据.
     *
     * @param AddressInterface[] $addresses
     *
     * @return AddressInterface[]
     */
    protected function extractAddressesWithoutChildren(array $addresses)
    {
        return array_map(function(AddressInterface $address){
            $address = clone $address;
            $address->setChildren([]);

            return $address;
        }, $addresses);
    }

    /**
     * 分拣数据.
     *
     * @param array $regions
     *
     * @return array
     */
    protected function organizeRegions($regions)
    {
        $provinces = $cities = $areas = [];
        foreach ($regions as $regionData) {
            if (substr($regionData['code'], 2) === '0000') {
                $province = new Province($regionData['code'], $regionData['name']);
                $province->parentCode = 0;
                $province->shortCode = substr($regionData['code'], 0, 2);
                $provinces[] = $province;
            } elseif (substr($regionData['code'], 4) === '00') {
                $city = new City($regionData['code'], $regionData['name']);
                $city->parentCode = substr($regionData['code'], 0, 2);
                $city->shortCode = substr($regionData['code'], 0, 4);
                $cities[] = $city;
            } else {
                $area = new District($regionData['code'], $regionData['name']);
                $area->parentCode = substr($regionData['code'], 0, 4);
                $area->shortCode = $regionData['code'];
                $areas[] = $area;
            }
        }

        return [
            $provinces,
            $cities,
            $areas,
        ];
    }

    protected function buildRegionsTree($addresses, AddressInterface $address)
    {
        $children = [];
        foreach ($addresses as $index => $_address) {
            if ($_address->parentCode == $address->shortCode) {
                unset($addresses[$index]);
                $this->buildRegionsTree($addresses, $_address);
                $children[] = $_address;
            }
        }
        $address->setChildren($children);
    }
}