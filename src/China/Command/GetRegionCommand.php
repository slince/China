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

        list($provinces, $cities, $areas, $tree) = $this->organizeRegions($regions);

        $this->filesystem->dumpFile($outputFile, \GuzzleHttp\json_encode($tree, JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
    }

    protected function organizeRegions($regions)
    {
        $provinces = $cities = $areas = [];

        foreach ($regions as $regionData) {
            if (substr($regionData['code'], 2) === '0000') {
                $provinces[$regionData['code']] = new Province($regionData['code'], $regionData['name']);
            } elseif (substr($regionData['code'], 4) === '00') {
                $cities[$regionData['code']] = new City($regionData['code'], $regionData['name']);
            } else {
                $areas[$regionData['code']] = new Area($regionData['code'], $regionData['name']);
            }
        }
        $tree = $this->buildRegionsTree(array_merge($provinces, $cities, $areas), new Province(0, null));

        return [
            'provinces' => $provinces,
            'cities' => $cities,
            'areas' => $areas,
            'tree' => $tree
        ];
    }

    protected function buildRegionsTree($addresses, AddressInterface $address)
    {
        $children = [];
        $shortCode = trim($address->getCode(), 0);
        foreach ($addresses as $index => $_address) {
            $_shortCode = trim($_address->getCode(), 0);
            if (strstr($_shortCode, $shortCode) === 0 && strlen($shortCode) + 2 === strlen($_shortCode)) {
                $this->buildTree($_address, $address);
                $children[] = $_address;
                unset($address[$index]);
            }
        }
        $address->setChildren($children);
    }
}