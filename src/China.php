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

namespace China;

use China\Common\ResourceFile;
use China\Holiday\HolidayService;
use China\Holiday\HolidayServiceInterface;
use China\Nationality\NationalityService;
use China\Nationality\NationalityServiceInterface;
use China\Region\RegionService;
use China\Region\RegionServiceInterface;
use Slince\Di\Container;

final class China
{
    /**
     * @var string
     */
    protected $name = '中国';

    /**
     * @var string
     */
    protected $officialName = '中华人民共和国';

    /**
     * @var string
     */
    protected $isoCode = 'CN';

    /**
     * @var array
     */
    protected $languages = ['zh_CN', 'zh_TW'];

    /**
     * @var string
     */
    protected $resourceDir;

    protected $container;

    public function __construct(string $resourceDir = __DIR__.'/../../resources/')
    {
        $this->container = new Container();
        $this->resourceDir = $resourceDir;
        $this->registerParameters();
        $this->registerService();
    }

    protected function registerParameters()
    {
        $this->container->setParameters([
            'resource.file.holidays' => $this->resourceDir.'holidays.json',
            'resource.file.nationalities' => $this->resourceDir.'nationalities.json',
            'resource.file.regions' => $this->resourceDir.'regions/regions.json',
        ]);
    }

    protected function registerService()
    {
        $this->container->register('holiday', function(Container $container){
            return new HolidayService(new ResourceFile($container->getParameter('resource.file.holidays')));
        });
        $this->container->register('nationality', function(Container $container){
            return new NationalityService(new ResourceFile($container->getParameter('resource.file.nationalities')));
        });
        $this->container->register('region', function(Container $container){
            return new RegionService(new ResourceFile($container->getParameter('resource.file.regions')));
        });
    }

    /**
     * 获取名称.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 获取官方名称.
     *
     * @return string
     */
    public function getOfficialName(): string
    {
        return $this->officialName;
    }

    /**
     * 获取ISO3166两位代码
     *
     * @return string
     */
    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    /**
     * 获取语言
     *
     * @return array
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * 获取Holiday服务
     *
     * @return HolidayServiceInterface
     */
    public function getHoliday(): HolidayServiceInterface
    {
        return $this->container->get('holiday');
    }

    /**
     * 获取Nationality服务
     *
     * @return NationalityServiceInterface
     */
    public function getNationality(): NationalityServiceInterface
    {
        return $this->container->get('nationality');
    }

    /**
     * 获取Region服务
     *
     * @return RegionServiceInterface
     */
    public function getRegion(): RegionServiceInterface
    {
        return $this->container->get('region');
    }
}