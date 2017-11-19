# 云抢答系统
用于小型多人的线下知识竞赛活动的在线抢答器，过去的一年间曾多次在厦门集美中学校园活动中使用。

使用该系统你需要一台电脑作为服务器和显示屏，然后让参与者的手机连接到这台电脑上，访问对应的地址进入抢答。

你同样可以将这个系统的服务端部署在服务器上（建议多线BGP机房，然后参与者使用手机LTE网络）。

用户界面：`index.html`

管理员界面：`admin.php`

初始管理员用户名和密码均为admin


在Debian 9上安装：
```
sudo su
cd /var/www/
git clone https://github.com/cyyself/vie-to-answer.git
apt install nginx php7.0-common php7.0-fpm php7.0-cli php7.0-json
cd vie-to-answer
php init.php
chown www-data:www-data /var/www/vie-to-answer/ -R
```
nginx配置文件：
```
server {
    listen 80;
    listen [::]:80;
    server_name qiangda.example.com;
    root /var/www/vie-to-answer;
    index index.html;
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php7.0-fpm.sock;
    }
    location ~ ^/(?:\.db){
        deny all;
    }
}
```
