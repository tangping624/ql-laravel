<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Route;

/**
 * 后台管理导航菜单数据
 */
class AdminNav
{
    protected $nav = [
        'category' => [
            'name' => '栏目管理',
            'route' => 'admin.category.index',
            'functions' => [
                'index' => ['name' => '栏目管理', 'route' => 'admin.category.index', 'display' => true],
            ]
        ],
        'merchant' => [
            'name' => '商户管理',
            'route' => 'admin.merchant.index',
            'functions' => [
                'index'   => ['name' => '商户列表', 'route' => 'admin.merchant.index', 'display' => true],
                'create'  => ['name' => '新增商户', 'route' => 'admin.merchant.create', 'display' => false],
                'edit'    => ['name' => '编辑商户', 'route' => 'admin.merchant.edit', 'display' => false],
                'product' => [
                    'name'    => '编辑商户',
                    'route'   => 'admin.merchant.edit',
                    'display' => false,
                    'actions' => [
                        'create' => ['name' => '新增产品', 'route' => 'admin.merchant.product.create', 'display' => false],
                        'edit'   => ['name' => '编辑产品', 'route' => 'admin.merchant.product.edit', 'display' => false],
                    ]
                ],
            ],
        ],
        'product' => [
            'name' => '产品管理',
            'route' => 'admin.product.index',
            'functions' => [
                'index'  => ['name' => '产品列表', 'route' => 'admin.product.index', 'display' => true],
                'create' => ['name' => '新增产品', 'route' => 'admin.product.create', 'display' => false],
                'edit'   => ['name' => '编辑产品', 'route' => 'admin.product.edit', 'display' => false],
            ],
        ],
        'admin' => [
            'name' => '管理员用户',
            'route' => 'admin.admin.index',
            'functions' => [
                'index' => ['name' => '管理员列表', 'route' => 'admin.admin.index', 'display' => true],

            ]
        ],
    ];

    public function compose(View $view)
    {
        $route = explode('.', Route::currentRouteName());

        $view->with([
            'nav'             => $this->nav, // 导航
            'currentModule'   => $route[1], // 模块 (level 1)
            'currentFunction' => $route[2] ?? '', // 功能 (level 2)
            'currentAction'   => $route[3] ?? '', // 操作 (level 3)
        ]);
    }
}
