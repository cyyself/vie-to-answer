FROM webdevops/php-nginx:debian-9

# RUN git clone https://github.com/cyyself/vie-to-answer.git
COPY src/ /var/www/vie-to-answer/
COPY 10-docker.conf /etc/nginx/conf.d/10-docker.conf

RUN cd /var/www/vie-to-answer/ && php init.php
RUN chown root:root /var/www/vie-to-answer/ -R
RUN chmod 755 /var/www/vie-to-answer/ -R
EXPOSE 80