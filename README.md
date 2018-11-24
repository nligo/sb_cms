# SB CMS

## 如何安装？

```
$ git clone https://github.com/nligo/sb_cms.git
$ cd sb_cms
$ composer install
$ yarn install
$ yarn encore dev 
```

#### 1、修改参数

打开 .env 文件设置数据库帐号、密码等相关参数。

```
DATABASE_URL=mysql://DB_USERNAME:DB_PASSWORD@127.0.0.1:3306/DB_NAME
```

#### 2、设置目录权限

```
$ chmod -R 0777 ./var
```

#### 3、创建数据库 & 创建表 & 添加测试数据

```
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
```

#### 4、测试帐号

```
帐号：admin
密码：123456
```


#### 访问 http://yourdomain.com/admin

