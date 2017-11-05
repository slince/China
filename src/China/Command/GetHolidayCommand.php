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

use China\Holiday\HolidayInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class GetHolidayCommand extends CrawlCommand
{
    /**
     * 节假日资源地址
     * @var string
     */
    const URL = 'http://www.sojson.com/time/holiday.html';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('crawler:holiday');
    }


    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = static::RESOURCE_DIR . '/holidays.json';

        $crawler = $this->getClient()->request('GET', static::URL);
        $holidays = $crawler->filter('.festival_list')->each(function(Crawler $node){
            $fontNode = $node->filter('font');
            return [
                'name' => $fontNode->text(),
                'type' => $this->convertClassToType($fontNode->attr('class')),
                'date' => $this->parseToDate($fontNode->text()),
            ];
        });

        $this->filesystem->dumpFile($outputFile, \GuzzleHttp\json_encode($holidays));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($output)));
    }

    protected function parseToDate($dateString)
    {
        return explode('/', trim($dateString, ']['));
    }

    protected function convertClassToType($class)
    {
        $type = '';
        switch ($class) {
            case 'red':
                $type = HolidayInterface::TYPE_TRADITIONAL;
                break;

            case 'green':
                $type = HolidayInterface::TYPE_INTERNATIONAL;
                break;

            case 'blue':
                $type = HolidayInterface::TYPE_SOLAR_TERM;
                break;
        }
        return $type;
    }
}