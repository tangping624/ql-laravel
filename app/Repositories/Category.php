<?php

namespace App\Repositories;

use App\Models\Category as Model;

class Category
{
    /**
     * 解析查询条件
     *
     * @param array $condition 查询条件
     * @return Builder
     */
    protected static function parseCondition($condition)
    {
        return Model::when(isset($condition['withScopeDisplay']), function ($query) {
                return $query->display();
            })
            ->when(isset($condition['withTags']), function ($query) {
                return $query->with('tags');
            })
            ->when(isset($condition['type']), function ($query) use ($condition) {
                return $query->where('type', $condition['type']);
            });
    }

    /**
     * 获取列表
     *
     * @param array $condition 查询条件
     * @param array $columns 查询字段
     * @param boolean $paginate 是否使用分页
     * @param string $orderColumn 排序列
     * @param string $orderDirection 排序方向
     * @return
     */
    public static function getList($condition = [], $columns = ['*'], $paginate = false, $orderColumn = 'sortord', $orderDirection = 'asc')
    {
        $query = static::parseCondition($condition)
            ->orderBy($orderColumn, $orderDirection)
            ->select($columns);

        return $paginate ? $query->paginate() : $query->get();
    }

    /**
     * 获取所有栏目
     *
     * @return
     */
    public static function allMerchant()
    {
        return static::getList(['withTags' => true, 'type' => 1]);
    }
}
