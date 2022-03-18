## 国内省市县地区查询

### 获取地区查询服务

所有的服务获取均通过 `China\China`对象；

```php
$china = new China\China();

$regionService = $china->getRegion();

$regionService->getProvinces(); // 获取所有的省（树形层级结构）
```

### 基本查询

- `findByName` 按照名称查询
- `findByCode` 按照地区码
- `filter` 按照自定义的闭包查询


```php
$anhui = $regionService->findByName('安徽省'):
$beijing = $regionService->findByName('110000'): //根据地区码
```

### 地区的链式结构

通过`AddressInterface`的`getParent()`和`getChildren()`方法你可以自由地查找当前地区的上级或者下级地区；
需要注意的是下级地区集合是`RegionCollectionInterfaec`实例，该实例支持上述的三条基本查询；

```php
$bengbushi = $regionService->findByName('蚌埠市');
echo $bengbushi->getParent()->getName(); //输出蚌埠市所属省， 安徽省
$yuhuiqu = $bengbushi->getChildren()->findByName('禹会区'); //获取蚌埠市下属禹会区
$yuhuiqu->getParent()->getChildren()->findByName('淮上区'); //获取禹会区同级淮上区
```

### 查找身份证归属地

```php
$huaiyuanxian = $regionService->findByIdCard('340321199212026972'); //怀远县
```
注意，你需要提供一个完整有效的身份证号码；查找出来的地区定位到县级地区；你可以通过地区的链式方法获取到省市级地区；

```php
$city = $huaiyuanxian->getParent(); //蚌埠市
$province = $huaiyuanxian->getParent()->getParent(); //安徽省
```