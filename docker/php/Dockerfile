FROM mileschou/phalcon:7.3-fpm-alpine

# 设置工作目录
WORKDIR /var/www/html

# 更换为国内阿里云镜像源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories
# 安装 Composer (直接从官方镜像拷贝二进制文件)
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 安装系统依赖并编译安装必要的 PHP 扩展
RUN apk add --no-cache \
        autoconf \
        g++ \
        make \
        pcre-dev \
        libzip-dev \
        libpng-dev \
        jpeg-dev \
        freetype-dev \
        imagemagick-dev \
        imagemagick \
        libgomp \
        icu-dev \
        oniguruma-dev \
        tzdata \
    # 使用 PECL 安装 Redis、Imagick 和 Zip 扩展
    && pecl install redis-5.3.7 imagick zip \
    # 启用相关扩展 (基础镜像自带 Phalcon 所以也显式标记 enable)
    && docker-php-ext-enable redis imagick phalcon zip \
    # 编译安装内置扩展
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo_mysql sockets bcmath pcntl intl gd \
    # 清理构建残留以减小镜像体积
    && apk del autoconf g++ make pcre-dev \
    && rm -rf /tmp/pear

# 配置时区
ENV TZ=Asia/Shanghai
RUN cp /usr/share/zoneinfo/Asia/Shanghai /etc/localtime && echo "Asia/Shanghai" > /etc/timezone
