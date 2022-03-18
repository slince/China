## 节日查询

### 获取所有的节日

```php

$holidayService = $china->getHoliday();

print_r($holidayService->findAll());

```
### 按名称查找节日

```php
$yuandan = $holidayService->find('元旦节'):
 
 echo $yuandan->getDate(); //输出 1月1日
```

### 按照节日类型

1. 获取传统节日
```php
$holidayService->findTraditionalHolidays();
```

2. 获取国际通用性节日
```php
$holidayService->findInternationalHolidays();
```

3. 获取24节气

```php
$holidayService->findSolarTermHolidays();
```