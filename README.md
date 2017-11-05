# Lemon

根据身份证的前4位数字获取该身份证的省会及城市。

[![Build Status](https://img.shields.io/travis/ddllin/lemon/master.svg?style=flat-square)](https://travis-ci.org/ddllin/lemon)
[![Coverage Status](https://img.shields.io/codecov/c/github/ddllin/lemon.svg?style=flat-square)](https://codecov.io/github/ddllin/lemon)
[![Latest Stable Version](https://img.shields.io/packagist/v/ddllin/lemon.svg?style=flat-square&label=stable)](https://packagist.org/packages/ddllin/lemon)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/ddllin/lemon.svg?style=flat-square)](https://scrutinizer-ci.com/g/ddllin/lemon/?branch=master)


## Installation

执行下面命令安装

```bash
> composer require ddllin/lemon
```


## Basic Usage

身份证前四位代表省会城市，所以必须传递，当然传递身份证全部编码也是可以的;

```php
require_once __DIR__ . '/vendor/autoload.php';

use Lemon\Query\Query;

var_dump(Query::query('xxxxx'));

```

返回格式为json字符串

```json
{
    "province": "云南省",
    "city": "玉溪市"
}
```

## License

The MIT license. See [MIT](https://opensource.org/licenses/MIT)









