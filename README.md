<p align="center">
   <img src="https://raw.githubusercontent.com/slince/china/master/resources/china.png" alt="中国">
</p>

我们的祖国-中国的资料库；本库主要包含民族，节日，地址库信息的查询；部分数据来源采集自百科以及国家统计局；欢迎收藏欢迎贡献代码；

[![Build Status](https://img.shields.io/travis/slince/china/master.svg?style=flat-square)](https://travis-ci.org/slince/china)
[![Coverage Status](https://img.shields.io/codecov/c/github/slince/china.svg?style=flat-square)](https://codecov.io/github/slince/china)
[![Latest Stable Version](https://img.shields.io/packagist/v/slince/china.svg?style=flat-square&label=stable)](https://packagist.org/packages/slince/china)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/slince/china.svg?style=flat-square)](https://scrutinizer-ci.com/g/slince/china/?branch=master)


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

## License

The MIT license. See [MIT](https://opensource.org/licenses/MIT)









