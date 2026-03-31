FROM mileschou/phalcon:7.3-fpm-alpine-3.4

# 设置工作目录
WORKDIR /var/www/html

# 更换为国内阿里云镜像源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

# 安装 Composer
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 安装系统依赖
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
    # 1. 使用 PECL 安装扩展 (注意：PHP 7.3 建议 zip 扩展通过 docker-php-ext-install 安装更稳定)
    && pecl install redis-5.3.7 imagick \
    && docker-php-ext-enable redis imagick phalcon \
    # 2. 配置并安装内置扩展
    # 注意：针对 PHP 7.3，如果下面的 --with-freetype 报错，请改回 --with-freetype-dir
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql sockets bcmath pcntl intl gd zip \
    # 3. 清理构建残留
    && apk del autoconf g++ make pcre-dev \
    && rm -rf /tmp/pear

# 配置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone