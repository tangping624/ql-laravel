<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('上传用户 id');
            $table->string('user_class')->comment('用户类');
            $table->char('md5', 32)->comment('图片内容 md5 哈希');
            $table->string('mime', 16)->comment('mime 类型');
            $table->string('uri')->comment('图片路径');
            $table->unsignedInteger('width')->default(0)->comment('图片宽');
            $table->unsignedInteger('height')->default(0)->comment('图片高');
            $table->unsignedInteger('size')->default(0)->comment('文件大小');
            $table->unsignedInteger('imageable_id')->default(0)->comment('图片所属对象 id');
            $table->string('imageable_type')->default('')->comment('图片所属对象类型');
            $table->unsignedTinyInteger('type')->default(1)->comment('图片类型');
            $table->integer('sortord')->default(0)->comment('排序');
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
        Schema::dropIfExists('images');
    }
}
