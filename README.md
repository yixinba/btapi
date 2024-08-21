##### 宝塔面板`API`接口


##### 环境

- php >=7.0.0

##### 安装
```php
composer require yixinba/btapi
```

##### 使用说明

```php
// Database|File|Ftp|Plugin|Site|System
// 以上都基础了[Base]都可以调用以下示例
$bt = new System('http://127.0.0.1:8888', 'Key', 'cookie保存目录设置');
$bt->getSystemTotal();
```