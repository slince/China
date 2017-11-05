<?php

namespace China\Command;

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
    }


    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = static::RESOURCE_DIR . '/nationalities.json';

        $crawler = $this->getClient()->request('GET', static::URL);

        $tables = $crawler->filter('table[log-set-param="table_view"]');
        $nationalities = $this->extractPinyinData($tables->first());

        $this->filesystem->dumpFile($outputFile, \GuzzleHttp\json_encode($nationalities, JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
    }

    protected function extractPinyinData(Crawler $crawler)
    {
        $nationalities = $crawler->filter('tr')->each(function(Crawler $itemNode){
            $data = [];
            foreach ($itemNode->filter('td') as $index => $tdNode) {
                if ($index % 2 === 0) {
                    $data[$index] = [
                        'name' => $tdNode->text(),
                        'pinyin' => false
                    ];
                } else {
                    $data[$index - 1]['pinyin'] = $tdNode->text();
                }
            }
            return $data;
        });
        return $nationalities
    }
}