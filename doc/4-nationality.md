## 民族查询

我国一共有56个民族，目前此服务只提供了基本的数据查询服务；如名称，人口以及拼音写法；此项服务数据摘自百度百科；

### 查找所有的民族
```php

$nationalityService = $chna->getNationality();

print_r($nationalityService->findAll()->count()); //56

```

### 按名称查找

```php
$hezhe = $nationalityService->find('赫哲族'):
 
 echo $hezhe->getPinyin(); //输出“hè zhé zú”
 echo $hezhe->getPopulation(); //输出人口
```