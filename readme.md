# 数据库字典生成工具

## 01. 简介

在我们开发使用mysql 新建非常多的表（有时候会多达好几百张表）时候，有时候会感觉压力老大了。

因为mysql中是没有做 database 和 schema 区分的。 但是在逻辑上做表的分组是非常有必要的，这个组件就是完成这个这个工作。

使用web界面提供一个简易的表逻辑分组

## 02. 使用方式

1. 首先安装
      ```
      composer require mr-jiawen/database-dictionary
      ```
2. 然后 进行数据迁移 (新建一个表 database_dictionary)
      ```
      php artisan migrate
      ```
3. 直接访问：
      ```
      http://localhost/database
      ```

## 03 注意事项：
如果需要 修改 uri , 可以在 config/database.php 文件设置 属性值：
```
'database_dictionary_uri' => 'database'        // 访问 数据库字典的uri
```
