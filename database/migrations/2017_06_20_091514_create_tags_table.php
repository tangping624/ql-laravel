<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('创建管理员 id');
            $table->string('name')->comment('标签名称');
            $table->integer('sortord')->default(0)->comment('排序');
            $table->tinyInteger('display')->default(1)->comment('是否显示');
            $table->unsignedInteger('taggable_id')->default(0)->comment('标签所属对象 id');
            $table->string('taggable_type')->default('')->comment('标签所属对象类型');
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
        Schema::dropIfExists('tags');
    }
}
