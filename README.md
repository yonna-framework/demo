[![License](https://img.shields.io/github/license/yonna-framework/yonna.svg)](https://packagist.org/packages/yonna/demo)
[![Repo Size](https://img.shields.io/github/repo-size/yonna-framework/yonna.svg)](https://packagist.org/packages/yonna/demo)
[![Version](https://img.shields.io/github/release/yonna-framework/yonna.svg)](https://packagist.org/packages/yonna/demo)

## Yonna

### 如何开始

> 克隆项目
```
git clone https://github.com/yonna-framework/yonna.git
```

> 安装 composer 依赖包 [composer](https://getcomposer.org/)
```
composer install
```

> 配置你的Apache服务器与虚机，指向 public/index.php，下面以Apache为例子

> linux 配置环境可使用 apt yum 等工具

> mac 配置环境可使用 [brew](https://brew.sh/)

> windows 配置环境可使用 [h-web-env-windows](https://github.com/hunzsig-server/h-web-env-windows)

 
 * apache 实例（仅供参考）
```
<VirtualHost *:80>
    DocumentRoot "/var/www/yonna/public"
    ServerName local.yonna.com
    <Directory "/var/www/yonna/public">
        Options +FollowSymLinks -Indexes
        RewriteEngine On
        RewriteCond %{REQUEST_FILENAME} !-d
        RewriteCond %{REQUEST_FILENAME} !-f
        RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
    </Directory>
</VirtualHost>
```

 * nginx 实例（仅供参考）
```
server {
    listen 80;
    charset utf8;
    server_name local.yonna.com;
    location / {
        root   /var/www/yonna/public;
        index  index.php;
        if (!-f $request_filename) {
            rewrite "^/(.*)$" /index.php/$1 last;
        }
    }
    location ~ \.(php) {
        root   /var/www/yonna/public;
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
        fastcgi_param  QUERY_STRING       $query_string;
        fastcgi_param  REQUEST_METHOD     $request_method;
        fastcgi_param  CONTENT_TYPE       $content_type;
        fastcgi_param  CONTENT_LENGTH     $content_length;
        fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
        fastcgi_param  REQUEST_URI        $request_uri;
        fastcgi_param  DOCUMENT_URI       $document_uri;
        fastcgi_param  DOCUMENT_ROOT      $document_root;
        fastcgi_param  SERVER_PROTOCOL    $server_protocol;
        fastcgi_param  REQUEST_SCHEME     $scheme;
        fastcgi_param  HTTPS              $https if_not_empty;
        fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
        fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;
        fastcgi_param  REMOTE_ADDR        $remote_addr;
        fastcgi_param  REMOTE_PORT        $remote_port;
        fastcgi_param  SERVER_ADDR        $server_addr;
        fastcgi_param  SERVER_PORT        $server_port;
        fastcgi_param  SERVER_NAME        $server_name;
        # PHP only, required if PHP was built with --enable-force-cgi-redirect
        fastcgi_param  REDIRECT_STATUS    200;
        set $redirect_url "0";
        if ($request_uri ~ "\?"){
            set $redirect_url "1";
        }
        if ($redirect_url = "0"){
            set $redirect_url $request_uri;
        }
        if ($request_uri ~ "^(.*)\?"){
            set $redirect_url $1;
        }
        fastcgi_param REDIRECT_URL $redirect_url;
    }
}
```