<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('创建管理员 id');
            $table->string('name')->comment('栏目名称');
            $table->string('path')->comment('栏目路径');
            $table->integer('sortord')->default(0)->comment('排序');
            $table->tinyInteger('display')->default(1)->comment('是否显示');
            $table->tinyInteger('type')->comment('栏目类型: 1.商家 2.文章 3.链接');
            $table->string('link_url')->default('')->comment('链接 URL');
            $table->unsignedInteger('created_at')->comment('创建时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
