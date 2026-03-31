FROM php:7.3-fpm-alpine

# 设置工作目录
WORKDIR /var/www/html

# 更换为国内镜像源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

# 安装构建依赖和业务依赖
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
        git \
    # 编译安装 Phalcon 3.4.5 (核心步骤)
    && git clone --depth=1 -b v3.4.5 https://github.com/phalcon/cphalcon.git /tmp/cphalcon \
    && cd /tmp/cphalcon/build \
    && ./install \
    && docker-php-ext-enable phalcon \
    # 安装 Redis 和 Imagick
    && pecl install redis-5.3.7 imagick \
    && docker-php-ext-enable redis imagick \
    # 配置并安装内置扩展
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql sockets bcmath pcntl intl gd zip \
    # 清理
    && rm -rf /tmp/cphalcon /tmp/pear \
    && apk del autoconf g++ make pcre-dev git

# 配置时区
ENV TZ=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone