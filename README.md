# phpure

### 如何开始

> 克隆项目
```
git clone https://github.com/hunzsig/phpure.git
```

> 安装composer依赖包
```
composer install
```

> 配置你的Apache服务器与虚机，指向 public/index.php，下面以Apache为例子
>> 如果不懂得配置环境可直接使用 [h-web-env-windows](https://github.com/hunzsig-server/h-web-env-windows)
```
<VirtualHost *:80>
    DocumentRoot "/var/www/phpure/public"
    ServerName myphpure.com
    <Directory "/var/www/phpure/public">
        Options +FollowSymLinks -Indexes
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
    </Directory>
</VirtualHost>
```
