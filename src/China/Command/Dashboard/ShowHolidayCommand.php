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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class ShowHolidayCommand extends DashboardCommand
{
    protected static $types = [
        HolidayInterface::TYPE_TRADITIONAL => '传统节日',
        HolidayInterface::TYPE_INTERNATIONAL => '国际节日',
        HolidayInterface::TYPE_SOLAR_TERM => '24节气',
    ];
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setName('dashboard:holiday');
        $this->addOption('type', 't', InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY, '按照类型筛选');
        $this->addOption('all', 'a',  InputOption::VALUE_NONE, '展现全部数据');
        $this->setDescription('展示节假日信息');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $holidayService = $this->getChina()->getHoliday();
        $style = new SymfonyStyle($input, $output);
        $headers = ['名称', '类型', '日期'];

        if ($input->getOption('all')) {
            $holidays = $holidayService->findAll()->toArray();
        } else {
            $types = $input->getOption('type');
            if (empty($types)) {
                $question = new ChoiceQuestion('请选择节日类型', static::$types, HolidayInterface::TYPE_TRADITIONAL);
                $question->setMultiselect(true);
                $helper = $this->getHelper('question');
                $types = $helper->ask($input, $output, $question);
            } else {
                $this->checkTypes($types);
            }
            $holidays = [];
            foreach ($types as $type) {
                $holidays = array_merge($holidays, $holidayService->findHolidaysByType($type)->toArray());
            }
        }
        $rows = array_map(function(HolidayInterface $holiday){
            return [
                "<info>{$holiday->getName()}</info>",
                static::$types[$holiday->getType()],
                $holiday->getDate()
            ];
        }, $holidays);
        $style->table($headers, $rows);
    }

    protected function checkTypes($types)
    {
        foreach ($types as $type) {
            if (!isset(static::$types[$type])) {
                throw new \InvalidArgumentException(sprintf('类型 "%s" 不支持，请从(%s)做出选择',
                    $type,
                    implode(', ', array_keys(static::$types))
                ));
            }
        }
    }
}