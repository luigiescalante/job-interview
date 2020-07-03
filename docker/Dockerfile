FROM scratch
ADD centos-8-x86_64.tar.xz /
RUN dnf -y update
RUN dnf -y install nginx php-fpm php php-mbstring php-cli php-pdo php-bcmath php-common php-json php-xml php-zip php-mysqlnd mysql
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer && \
    mkdir /run/php-fpm/ && \
    usermod -u 1000 nginx && \
    groupmod -g 1000 nginx && \
    mkdir /etc/pki/nginx/ && \ 
    mkdir /etc/pki/nginx/private/
COPY nginx.conf /etc/nginx/nginx.conf  
COPY www.conf /etc/php-fpm.d/www.conf
RUN openssl req -x509 -out /etc/pki/nginx/server.crt -keyout /etc/pki/nginx/private/server.key -newkey rsa:2048 -nodes -sha256 -subj '/CN=localhost'
COPY entrypoint.sh /usr/local/entrypoint.sh
WORKDIR /usr/share/nginx/html/
EXPOSE 80 443
RUN chmod 711 /usr/local/entrypoint.sh
ENTRYPOINT ["/usr/local/entrypoint.sh"]
CMD ["/bin/bash"]