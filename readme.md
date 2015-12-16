# [Viease](http://viease.cn/)

微易，一款基于 [overtrue/wechat](https://github.com/overtrue/wechat) 开发的微信公众平台管理系统框架。http://viease.cn/

# 安装

1. Git clone 并安装

 ```shell
 git clone https://github.com/vieasehub/viease
 cd viease
 composer install -v
 chmod -R 777 storage
 chmod -R 777 bootstrap/cache
 ```

2. 创建 `.env` 文件

 ```shell
 $ curl https://raw.githubusercontent.com/laravel/laravel/master/.env.example -o .env
 // 生成key
 $ php artisan key:generate
 ```

 以及修改 `.env` 内对应的项目

3. 配置 nginx 虚拟主机

 ```
 server {
     listen 80;
     server_name viease.app; # 有必要改成你的域名
     root "/path/to/viease"; # 这里改成你的viease所在目录的public

     index index.html index.htm index.php;

     charset utf-8;

     location / {
         try_files $uri $uri/ /index.php?$query_string;
     }

     location = /favicon.ico { access_log off; log_not_found off; }
     location = /robots.txt  { access_log off; log_not_found off; }

     access_log /usr/local/var/log/nginx/viease.app-access.log;
     error_log  /usr/local/var/log/nginx/viease.app-error.log error;

     sendfile off;

     client_max_body_size 100m;

     location ~ \.php$ {
         fastcgi_split_path_info ^(.+\.php)(/.+)$;
         fastcgi_pass 127.0.0.1:9000;
         fastcgi_index index.php;
         include fastcgi_params;
         fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         fastcgi_intercept_errors off;
         fastcgi_buffer_size 16k;
         fastcgi_buffers 4 16k;
     }

     location ~ /\.ht {
         deny all;
     }
 }
 ```
4. 创建数据库

 确保你的 `.env` 里的数据库配置已经 OK.

 ```shell
 $ php artisan migrate
 $ php artisan db:seed
 ```

5. 访问后台： `yourdomain.com/admin`

 ```
 email: admin
 password: viease
 ```

6. 添加公众号
7. 同步粉丝

 ```shell
 $ php artisan sync:all_fans # 获取全部公众号,同步粉丝
 $ php artisan sync:all_groups # 获取全部公众号,同步粉丝组
 ```
 这一步估计耗时很长...

完事。

# 说明
本项目后台部分功能未完成，我们期望有时间的朋友可以补充完成后提交，谢谢！QQ群：319502940

# License

MIT