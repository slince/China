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

use China\Nationality\Nationality;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class GetNationalityCommand extends CrawlCommand
{
    /**
     * @var string
     */
    const URL = 'https://baike.baidu.com/item/56个民族/383735';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('crawl:nationality');
        $this->setDescription('从百度百科采集民族信息');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = static::RESOURCE_DIR.'/nationalities.json';

        $crawler = $this->getClient()->request('GET', static::URL);

        $tables = $crawler->filter('table[log-set-param="table_view"]');
        $nationalities = $this->extractPinyinData($tables->eq(1));
        $populations = $this->extractPopulationData($tables->eq(2));

        $nationalities = $this->mergeData($nationalities,$populations);
        $this->filesystem->dumpFile($outputFile, \GuzzleHttp\json_encode($nationalities, JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
    }

    protected function extractPinyinData(Crawler $crawler)
    {
        $nationalities = $crawler->filter('tr')->each(function(Crawler $itemNode){
            $data = [];
            $itemNode->filter('td')->each(function(Crawler $tdNode, $index) use (&$data){
                if ($index % 2 === 0) {
                    $data[$index] = [
                        'name' => trim($tdNode->text()),
                        'pinyin' => false,
                    ];
                } else {
                    $data[$index - 1]['pinyin'] = trim($tdNode->text());
                }
            });

            return $data;
        });

        return call_user_func_array('array_merge', $nationalities);
    }

    protected function extractPopulationData(Crawler $crawler)
    {
        $data = [];
        $crawler->filter('tr')->each(function(Crawler $itemNode) use (&$data){
            $tds = $itemNode->filter('td');
            if (count($tds) > 0) {
                $name = trim($tds->first()->text());
                $data[$name] = trim($tds->eq(1)->text());
            }
        });

        return $data;
    }

    protected function mergeData($nationalityInfos, $populations)
    {
        $nationalities = [];
        foreach ($nationalityInfos as $nationalityInfo) {
            $nationalities[] = new Nationality($nationalityInfo['name'],
                $nationalityInfo['pinyin'],
                isset($populations[$nationalityInfo['name']]) ? $populations[$nationalityInfo['name']] : 0
            );
        }

        return $nationalities;
    }
}