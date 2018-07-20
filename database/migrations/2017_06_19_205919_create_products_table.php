<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('创建管理员 id');
            $table->tinyInteger('status')->default(1)->comment('状态: 0.未发布 1.正常');
            $table->string('name')->comment('产品名称');
            $table->unsignedInteger('merchant_id')->comment('商户 id');
            $table->mediumText('information')->comment('基本信息');
            $table->mediumText('introduction')->comment('简介');
            $table->unsignedInteger('created_at')->comment('创建时间');
            $table->unsignedInteger('updated_at')->comment('更新时间');
            $table->unsignedInteger('deleted_at')->nullable()->comment('删除时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
