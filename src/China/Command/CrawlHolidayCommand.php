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

use China\Holiday\Date;
use China\Holiday\Holiday;
use China\Holiday\HolidayInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class CrawlHolidayCommand extends CrawlCommand
{
    /**
     * 节假日资源地址
     *
     * @var string
     */
    const URL = 'http://www.sojson.com/time/holiday.html';

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('crawl:holiday');
        $this->setDescription('采集节假日数据');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $outputFile = $this->resourceDir.'/holidays.json';

        $crawler = $this->getClient()->request('GET', static::URL);
        $holidays = $crawler->filter('.festival_list')->each(function(Crawler $node){
            $fontNode = $node->filter('font');
            $date = $this->parseToDate(strstr($node->text(), '['));
            $date = new Date($date[0], $date[1]);
            $type = $this->convertColorToType($fontNode->attr('color'));

            return new Holiday($fontNode->text(), $type, $date);
        });

        $this->filesystem->dumpFile($outputFile, \json_encode($holidays, JSON_UNESCAPED_UNICODE));

        $style->writeln(sprintf('<info>Crawl completed, please check the file at "%s"</info>', realpath($outputFile)));
        return 0;
    }

    protected function parseToDate(string $dateString)
    {
        return explode('/', trim($dateString, ']['));
    }

    protected function convertColorToType(string $class): string
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