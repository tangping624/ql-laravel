<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = time();
        \DB::table('categories')->insert([
            ['admin_id' => 1, 'name' => '百科', 'path' => 'wiki', 'type' => 2, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '合作交流', 'path' => '合作', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '移民', 'path' => 'immigrant', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '专业服务', 'path' => 'service', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '投资项目', 'path' => 'investment', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '教育培训', 'path' => 'education', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '携程', 'path' => 'ctrip', 'type' => 3, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '资讯问答', 'path' => 'mood', 'type' => 3, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '旅游', 'path' => 'tour', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => 'VIP 服务', 'path' => 'vip', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '房产', 'path' => 'housing', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '紧急', 'path' => 'urgency', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '购物惠', 'path' => 'shoping', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '外汇', 'path' => 'forex', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '休闲娱乐', 'path' => 'entertainment', 'type' => 1, 'created_at' => $timestamp],
            ['admin_id' => 1, 'name' => '全部分类', 'path' => 'whole', 'type' => 3, 'created_at' => $timestamp],
        ]);
    }
}
