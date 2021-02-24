# 云抢答系统
用于小型多人的线下知识竞赛活动的在线抢答器，过去的一年间曾多次在厦门集美中学校园活动中使用。

使用该系统你需要一台电脑作为服务器和显示屏，然后让参与者的手机连接到这台电脑上，访问对应的地址进入抢答。

你同样可以将这个系统的服务端部署在服务器上（建议多线BGP机房，然后参与者使用手机LTE网络）。

请确保服务器与客户端之间网络丢包率极低，由于TCP丢包重传机制通常为1秒时限。如果抢答者点击“抢答”按钮时向服务器发送的请求出现了丢包的情况，将导致这位抢答者点击抢答到服务器的接收的网络延迟上升到秒的级别。

通常情况下，抢答者点击抢答到服务器接收到请求仅需要消耗1*rtt，也就是ping服务器的延迟。请确保服务器的http keep alive出于开启状态，并开启tcp fast open以防万一。（我当然希望有人使用webrtc的udp功能把这个项目造的更好)

用户界面：`index.html`

管理员界面：`admin.php`

初始管理员用户名和密码均为admin


## 在Debian 9上安装：
```
sudo su
cd /var/www/
git clone https://github.com/cyyself/vie-to-answer.git
apt install nginx php7.0-common php7.0-fpm php7.0-cli php7.0-json
cd vie-to-answer
mv src/* .
php init.php
chown www-data:www-data /var/www/vie-to-answer/ -R
# 如果出现一点击“新建抢答”就提示抢答结束的情况多半是没有执行chown
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

## 使用Docker
```
docker build -t vie-to-answer .
docker run --init -d -p 80:80  --name vie-to-answer vie-to-answer
```
