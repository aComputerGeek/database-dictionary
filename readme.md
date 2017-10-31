# 数据库字典生成工具

### 01 第一部分 引入路由 

```markdown
Route::any('/database/markdown',"\CjwDBMD\src\DatabaseMarkdownController@index");
```
这是所有的路由入口，内部通过`url=xxx`方法名进行对应的方法来处理业务逻辑

### 02 数据迁移
需要手动的创建数据迁移
```markdown
php artisan make:migration create_database_markdown_table --create=database_markdown
```
然后需要编写数据迁移文件:
```markdown
/**
 * Run the migrations.
 *
 * @return void
 */
public function up()
{
    Schema::create('database_markdown', function (Blueprint $table) {
        $table->increments('id');
        $table->string("name",255);
        $table->tinyInteger("type");
        $table->integer('father_id');
        $table->integer('order');
        $table->timestamps();
    });
}

/**
 * Reverse the migrations.
 *
 * @return void
 */
public function down()
{
    Schema::dropIfExists('database_markdown');
}
```

### 03 接着，手动把模块分好
```markdown
XXXXXXXXXX
```
### 04 最后生成markdown文件
生成的目录在下面的目录中：`storage/database`
