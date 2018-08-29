<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabaseDictionary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('database_dictionary', function (Blueprint $table) {
            $table->increments('id')->comment('主键');
            $table->string("title",255)->default('')->comment('模块名称/数据表名');
            $table->tinyInteger("type")->default(1)->comment('类型：1 表示是模块数据，2表示表名数据');
            $table->integer('father_id')->default(0)->comment('父级的id号');
            $table->integer('order')->default(0)->comment('排序');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `database_dictionary` comment'数据库字典表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('database_dictionary');
    }
}
