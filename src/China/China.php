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
use Slince\Di\Container;

class China
{
    protected $name;

    protected $officialName;

    protected $isoCode;

    protected $language;

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
}