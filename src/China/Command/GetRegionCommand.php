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

use China\Region\Location\AddressInterface;
use China\Region\Location\Area;
use China\Region\Location\City;
use China\Region\Location\Province;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class GetRegionCommand extends CrawlCommand
{
    /**
     * 资源地址
     * @var string
     */
    const URL = 'http://www.stats.gov.cn/tjsj/tjbz/xzqhdm/201703/t20170310_1471429.html';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('crawl:region');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = static::RESOURCE_DIR . '/regions/regions.json';

        $crawler = $this->getClient()->request('GET', static::URL);

        $provinces = $cities = $areas = [];
        $regions = $crawler->filter('p.MsoNormal')->each(function(Crawler $node) use (&$provinces, &$cities, &$areas){
            if (count($bNodes = $node->filter('b')) === 2) {
                $code = $bNodes->first()->text();
                $name = $bNodes->last()->text();
            } else {
                $codeNode = $node->filter('span[lang="EN-US"]');
                $code = $codeNode->text();
                $name = $codeNode->nextAll()->text();
            }
            return [
                'code' => preg_replace('/[^\d]/', '', $code),
                'name' => $this->clearBlankCharacters($name)
            ];
        });
        //归类数据
        list($provinces, $cities, $areas) = $this->organizeRegions($regions);
        //构建树形结构
        $root = new Province(0, null);
        $this->buildRegionsTree(array_merge($provinces, $cities, $areas), $root);

        $this->filesystem->dumpFile(static::RESOURCE_DIR . '/regions/provinces.json', \GuzzleHttp\json_encode($provinces, JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile(static::RESOURCE_DIR . '/regions/cities.json', \GuzzleHttp\json_encode($cities, JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile(static::RESOURCE_DIR . '/regions/areas.json', \GuzzleHttp\json_encode($areas, JSON_UNESCAPED_UNICODE));
        $this->filesystem->dumpFile($outputFile, \GuzzleHttp\json_encode($root->getChildren(), JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
    }

    /**
     * 分拣数据
     * @param array $regions
     * @return array
     */
    protected function organizeRegions($regions)
    {
        $provinces = $cities = $areas = [];
        foreach ($regions as $regionData) {
            if (substr($regionData['code'], 2) === '0000') {
                $provinces[] = new Province($regionData['code'], $regionData['name']);
            } elseif (substr($regionData['code'], 4) === '00') {
                $cities[] = new City($regionData['code'], $regionData['name']);
            } else {
                $areas[] = new Area($regionData['code'], $regionData['name']);
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
        $shortCode = trim($address->getCode(), 0);

        foreach ($addresses as $index => $_address) {
            $_shortCode = trim($_address->getCode(), 0);
            if ((!$shortCode || strpos($_shortCode, $shortCode) === 0) && strlen($shortCode) + 2 === strlen($_shortCode)) {
                unset($addresses[$index]);
                $this->buildRegionsTree($addresses, $_address, true);
                $children[] = $_address;
            }
        }
        $address->setChildren($children);
    }
}