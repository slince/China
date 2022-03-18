<p align="center">
   <img src="https://raw.githubusercontent.com/slince/china/master/etc/china.png" alt="中国">
</p>

我国的资料库查询库；本库主要包含民族、节日、地址库信息的查询；部分数据来源采集自百科以及国家统计局；欢迎收藏欢迎贡献代码；

[![Build Status](https://img.shields.io/travis/slince/China/master.svg?style=flat-square)](https://travis-ci.org/slince/China)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/china.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/china)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/China.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/China/?branch=master)


## Installation

执行下面命令安装

```bash
> composer require slince/china
```

## Document

你可以在这里发现[文档](./resources/doc);

## Basic Usage

### 节日查询

```php

$china = new China();

$holidayService = $chna->getHoliday();

print_r($holidayService->findAll());

```
按名称查找节日

```php
$yuandan = $holidayService->find('元旦节'):
 
 echo $yuandan->getDate(); //输出 1月1日
```

### 民族查询

```php

$china = new China();

$nationalityService = $chna->getNationality();

print_r($nationalityService->findAll());

```

按名称查找

```php
$hezhe = $nationalityService->find('赫哲族'):
 
 echo $hezhe->getPinyin(); //输出“hè zhé zú”
 echo $hezhe->getPopulation(); //输出人口
```


### 地址库查询


```php

$china = new China();

$regionService = $china->getRegion();

print_r($regionService->getProvinces()); //获取树形省市县地区结构
```

按名称查找地区

```php
$bengbushi = $regionService->findByName('蚌埠市');
echo $bengbushi->getParent()->getName(); //输出蚌埠市所属省， 安徽省
```

查询身份证所在地

```php
$huaiyuan = $regionService->findByIdCard('340321199212026972');
```

地区链功能

通过`AddressInterface`的`getParent()`和`getChildren()`方法你可以自由地查找当前地区的上级或者下级地区，下级地区集合是`RegionCollectionInterfaec`
实例；

```php
$yuhuiqu = $bengbushi->getChildren()->findByName('禹会区'); //蚌埠市下属禹会区
$yuhuiqu->getParent()->getChildren()->findByName('淮上区'); //禹会区同级淮上区
```
Json Serialize

```php
$bengbushi = $regionService->findByName('蚌埠市');
echo json_encode($bengbushi);
```
上述代码会输出蚌埠市及其下属地区的完整的json树形结构；如果你不需要的话下级地区的话请将children设置为空

```php
$bengbushi = $regionService->findByName('蚌埠市');
$bengbushi = clone $bengbushi; //此处需要克隆对象，如果直接修改会破坏原有的地区树结构
$bengbushi->setChildren([]);
echo json_encode($bengbushi);
```

> 建议：在电商系统中城市县三级地区联动的数据可以使用此方法获取，避免将数据导入数据库再从数据库获取；


## 命令行工具

执行下面命令查看支持的所有命令

```bash
$ china list
```
输出信息：
```
Available commands:
  help                   Displays help for a command
  list                   Lists commands
 crawl
  crawl:holiday          采集节假日数据
  crawl:nationality      从百度百科采集民族信息
  crawl:region           从国家统计局采集地区信息
 view
  view:holiday      展示节假日信息
  view:nationality  展示民族数据信息
  view:region       展示我国省市县信息
```

例: 展示我国所有的省、直辖市、自治区以及特别行政区：

```bash
$ china  dashboard:region
```
上述命令会输出以下结果：

```
 -------- ------------------ ------
  Code     名称               类型
 -------- ------------------ ------
  110000   北京市             省
  120000   天津市             省
  130000   河北省             省
  140000   山西省             省
  150000   内蒙古自治区       省
  210000   辽宁省             省
  220000   吉林省             省
  230000   黑龙江省           省
  310000   上海市             省
  320000   江苏省             省
  330000   浙江省             省
  340000   安徽省             省
  350000   福建省             省
  360000   江西省             省
  370000   山东省             省
  410000   河南省             省
  420000   湖北省             省
  430000   湖南省             省
  440000   广东省             省
  450000   广西壮族自治区     省
  460000   海南省             省
  500000   重庆市             省
  510000   四川省             省
  520000   贵州省             省
  530000   云南省             省
  540000   西藏自治区         省
  610000   陕西省             省
  620000   甘肃省             省
  630000   青海省             省
  640000   宁夏回族自治区     省
  650000   新疆维吾尔自治区   省
  710000   台湾省             省
  810000   香港特别行政区     省
  820000   澳门特别行政区     省
 -------- ------------------ ------
```
...

## License

The MIT license. See [MIT](https://opensource.org/licenses/MIT)









