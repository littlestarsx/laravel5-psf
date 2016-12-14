# laravl5-psf

psf client for Laravel 5

## 安装

1. 安装包文件

  ```shell
  composer require "fenxiangpaomo/laravel5-psf:dev-master"
  ```

## 配置

### Laravel 应用

1. 注册 `ServiceProvider`，修改`config/app.php`中的`providers`部份，增加:

  ```php
  Psf\Laravel\ServiceProvider::class,
  ```

2. 创建配置文件：

  ```shell
  php artisan vendor:publish
  ```

3. 请修改应用根目录下的 `config/psf.php` 中对应的项即可；

4. （可选）添加外观到 `config/app.php` 中的 `aliases` 部分:

  ```php
  'Psf' => Psf\Laravel\Facade::class,
  ```

## 使用


### 我们有以下方式获取 psf 的服务实例

##### 使用容器的自动注入

```php
<?php

namespace App\Http\Controllers;

use Psf\Laravel\Psf 

class WechatController extends Controller
{

    public function demo(Psf $psf)
    {
        // $psf 则为容器中 Psf\Laravel\Psf 的实例
        $resultObj = $psf->group('car')->call('\Car\Service\SerieApi::getAll', [1, 1]);
        $result = $resultObj->getResult();
    }
}

```

##### 使用外观

在 `config/app.php` 中 `alias` 部分添加外观别名：

```php
  'Psf' => Psf\Laravel\Facade::class,
```

然后就可以在任何地方使用外观方式调用 SDK 对应的服务了：

```php
$resultObj = Psf::group('car')->call('\Car\Service\SerieApi::getAll', [1, 1]);
$result = $resultObj->getResult();

```

##### 使用帮助函数

```php
$resultObj = psf()->group('car')->call('\Car\Service\SerieApi::getAll', [1, 1]);
$result = $resultObj->getResult();

或
$resultObj = psf('car')->call('\Car\Service\SerieApi::getAll', [1, 1]);
$result = $resultObj->getResult();
```



## License

MIT
