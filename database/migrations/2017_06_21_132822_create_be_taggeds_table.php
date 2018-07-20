<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeTaggedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('be_taggeds', function (Blueprint $table) {
            $table->unsignedInteger('tag_id')->comment('tag id');
            $table->unsignedInteger('be_tagged_id')->comment('被 tag 对象 id');
            $table->string('be_tagged_type')->comment('被 tag 对象类');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('be_taggeds');
    }
}
