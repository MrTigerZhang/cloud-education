# 云课堂 Docker 一键部署与启动指南

经过自动化重构，我们已经为您构建了一套完整的 `docker-compose` 编排环境，此方案可以一键启动项目的核心关联服务结构。

运行环境一览：

- ✅ **PHP/Web业务 (`app`)**：附带 Phalcon、Redis、PDO等所有拓展的 PHP 7.3
- ✅ **前端接入 (`nginx`)**：基于 Alpine 和预配的重写伪静态站点
- ✅ **通信信使 (`websocket`)**：Workerman 的消息和注册中心
- ✅ **定时任务 (`scheduler`)**：持久调度的 crontab 模拟器
- ✅ **底层存储与中间件**：`mysql` 5.7, `redis` 5.0, `xunsearch` 1.4

## 0. 目录结构

- `docker-compose.yml`：环境的启动中枢文件
- `docker/nginx/default.conf`：Nginx 的基础路由和转发逻辑
- `docker/php/Dockerfile`：封装好各项 PECL 扩展和核心工具链的自定义 PHP 容器脚本
- `DOCKER_README.md`：本指南文档

---

## 1. ⚠️ 重要前置调整：还原网关配置

如果您在同一套物理机上运行 Docker 全家桶（包括将 MySQL 和 Redis 都由刚才的容器产生），由于目前在 Docker 内网网段内，诸如 PHP 或 Nginx 解析外部的 `192.168.1.14` 会失效或存在通讯绕路，因此您必须修改应用以指向“内网服务名称”：

请编辑 `config/config.default.php` 获取通信授权：

```php
/**
 * 数据库主机名
 */
$config['db']['host'] = 'mysql';

/**
 * redis主机名
 */
$config['redis']['host'] = 'redis';
```

_(说明：在 `docker-compose` 环境中，服务间直接使用 `mysql` 及 `redis` 作为内部 Host 解析)_

---

## 2. 构建并一键启动环境

打开终端/PowerShell 切换到项目根目录，也就是本文件同级目录下进行：

```bash
# 后台一键拉起整个集群（初次附带镜像构建过程，需几分钟时间）
docker-compose up -d
```

完成后可以检查所有运行的容器情况：

```bash
docker-compose ps
```

---

## 3. 初次数据和依赖初始化

容器本身启动只具备底层运行机制和环境，业务初始化请通过以下命令自动完成：

**(1) （如果您刚克隆项目，还未安装核心库）运行安装 Composer 指令：**

```bash
docker exec -it ctc-php-fpm sh -c "composer install --no-dev"
```

**(2) 同步 MySQL 数据库表结构（执行项目的 Phinx Migration）：**

```bash
docker exec -it ctc-php-fpm sh -c "php vendor/bin/phinx migrate"
```

**(3) 如有初始的数据 SQL，也可以轻松导给容器 MySQL 账中：**

```bash
# (此处将 your_sql_file.sql 放入本文件同级目录后执行)
docker exec -i ctc-mysql mysql -uroot -proot123asD education < your_sql_file.sql
```

---

## 4. 常见运维命令和错误排查

- **查看常驻 Websocket 服务运行状态**
  当您的通信推送异常时：
  `docker logs ctc-websocket --tail=100 -f`
- **查看 Nginx/PHP 调试信息**
  `docker logs ctc-nginx`
  `docker logs ctc-php-fpm`
- **重启全部应用进程（代码变动或者热更时）**
  `docker-compose restart`
- **关闭整个服务集群**
  `docker-compose down`

---

## 5. 🚀 生产服务器部署指南 (Linux 云主机)

将本项目通过 Docker 独立部署到生产服务器（如阿里云、腾讯云等 Linux 主机）非常简单，核心思想就是 **“传输代码 -> 修改生产外网IP -> 服务器拉起”**。

### 步骤 1：准备与代码传输

1. 准备一台装有 Docker 和 docker-compose 的 Linux 服务器（Ubuntu/CentOS）。
2. 将本地打包好的项目压缩包（`zip` 格式，注意排除庞大的 `vendor/` 核心缓存）上传至云服务器并解压，或者直接在服务器使用 Git 克隆本代码。

### 步骤 2：修改关键公网配置（最重要的一步）

代码同步过去后，修改项目核心文件 `config/config.default.php`：

1. **连接环境**：`env` 改为 `pro`（生产模式）。
2. **数据库及 Redis 通讯**：`$config['db']['host']` 和 `$config['redis']['host']` 密码建议增加强度，但主域名务必保持为容器内网通讯的别称即 **`mysql` 和 `redis`**。
3. **Websocket 连接公网寻址**：找到并修改您对外暴漏的 Websocket IP（在客户端 js 连接时必用），将其替换为您服务器的**真实公网 IP 或域名**：
   ```php
   $config['websocket']['connect_address'] = '你的服务器公网IP:8282';
   ```

### 步骤 3：放行公网防火墙安全组

在您的云服务器厂商控制台（如腾讯云），找到服务器关联的安全防火墙规则，确保给公网开放了以下端口：

- **`80`** (网站 HTTP 访问主端口)
- **`8282` / `1238`** (Workerman WebSocket 推送心跳访问端口)
  _(提示：`3306` 数据库 和 `6379` 缓存不要随便在安全组中全部放行给公网，因为 Docker 容器间用的是虚拟化内部网桥交互，关闭公网更安全。)_

### 步骤 4：在服务器上一键上线！

命令行进入服务器上的解压出来的项目根目录并运行：

```bash
# 后台一键拉起部署所有底层依赖环境
docker-compose up -d

# 给新建立的无环境服务器拉满 PHP composer 包
docker exec -it ctc-php-fpm sh -c "composer install --no-dev"

# 构建线上版数据库所有表结构
docker exec -it ctc-php-fpm sh -c "php vendor/bin/phinx migrate"
```

等执行完毕即可直接在您的浏览器输入服务器 IP 或绑定的域名，享受完整版功能！

# 1. 启动完整的微服务集群 (-d 代表后台常驻执行)

docker-compose up -d

# 2. 如果您排除了 vendor 文件夹，执行这一步安装所有 PHP 扩展包

docker exec -it ctc-php-fpm sh -c "composer install --no-dev"

# 3. 运行基础数据库的建表和数据迁移

docker exec -it ctc-php-fpm sh -c "php vendor/bin/phinx migrate"
