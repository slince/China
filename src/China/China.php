<?php
/*
 * This file is part of the Slince/China package.
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace China;

define('RESOURCE_DIR', __DIR__  . '/../../resources/');

use China\Common\ResourceFile;
use China\Holiday\HolidayService;
use China\Holiday\HolidayServiceInterface;
use China\Nationality\NationalityService;
use China\Nationality\NationalityServiceInterface;
use China\Region\RegionService;
use China\Region\RegionServiceInterface;
use Slince\Di\Container;

class China
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

    protected $container;

    public function __construct()
    {
        $this->container = new Container();
        $this->registerParameters();
        $this->registerService();
    }

    protected function registerParameters()
    {
        $this->container->setParameters([
            'resource.file.holidays' => RESOURCE_DIR  . 'holidays.json',
            'resource.file.nationalities' => RESOURCE_DIR  . 'nationalities.json',
            'resource.file.regions' => RESOURCE_DIR  . 'regions/regions.json',
        ]);
    }

    protected function registerService()
    {
        $this->container->set('holiday', function(Container $container){
            return new HolidayService(new ResourceFile($container->getParameter('resource.file.holidays')));
        });
        $this->container->set('nationality', function(Container $container){
            return new NationalityService(new ResourceFile($container->getParameter('resource.file.nationalities')));
        });
        $this->container->set('region', function(Container $container){
            return new RegionService(new ResourceFile($container->getParameter('resource.file.regions')));
        });
    }

    /**
     * 获取Holiday服务
     * @return HolidayServiceInterface
     */
    public function getHoliday()
    {
        return $this->container->get('holiday');
    }

    /**
     * 获取Nationality服务
     * @return NationalityServiceInterface
     */
    public function getNationality()
    {
        return $this->container->get('nationality');
    }

    /**
     * 获取Region服务
     * @return RegionServiceInterface
     */
    public function getRegion()
    {
        return $this->container->get('region');
    }

    /**
     * 获取名称
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 获取官方名称
     * @return string
     */
    public function getOfficialName()
    {
        return $this->officialName;
    }

    /**
     * 获取ISO3166两位代码
     * @return string
     */
    public function getIsoCode()
    {
        return $this->isoCode;
    }

    /**
     * 获取语言
     * @return array
     */
    public function getLanguages()
    {
        return $this->languages;
    }
}