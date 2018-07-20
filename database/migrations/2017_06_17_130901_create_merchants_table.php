<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('admin_id')->comment('创建管理员 id');
            $table->tinyInteger('status')->default(1)->comment('状态: 0.未发布 1.正常');
            $table->unsignedInteger('category_id')->comment('商家所属栏目');
            $table->string('name')->comment('名称');
            $table->string('contacts', 50)->default('')->comment('联系人');
            $table->string('telephone', 30)->default('')->comment('电话');
            $table->string('fax', 30)->default('')->comment('传真');
            $table->string('email')->default('')->comment('邮箱');
            $table->integer('sortord')->default(0)->comment('排序');
            $table->tinyInteger('ad_cate')->default(0)->comment('是否栏目广告');
            $table->tinyInteger('ad_tag')->default(0)->comment('是否栏目分类广告');
            $table->string('address')->default('')->comment('地址');
            $table->string('long')->default('')->comment('位置经度');
            $table->string('lat')->default('')->comment('位置纬度');
            $table->text('summary')->comment('简介');
            $table->text('attention')->comment('特别提醒');
            $table->mediumText('description')->comment('详情');
            $table->unsignedInteger('pv')->default(0)->comment('点击量');
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
        Schema::dropIfExists('merchants');
    }
}
