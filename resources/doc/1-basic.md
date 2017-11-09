## 安装

执行下面命令安装

```bash
$ composer require slince/china
```

## Basic Usage

### 节日查询

```php

$china = new China();

$holidayService = $china->getHoliday();

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

$regionService = $chna->getRegion();

print_r($regionService->getProvinces()); //获取树形省市县地区结构
```
