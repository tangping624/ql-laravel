<?php

namespace App\Repositories;

use App\Models\Merchant as Model;

use Auth;

class Merchant
{
    /**
     * 创建空信息商户
     *
     * @param  array $data
     * @return
     */
    public static function createEmpty()
    {
        return Model::create([
            'admin_id'    => Auth::user()->id,
            'name'        => '',
            'contacts'    => '',
            'telephone'   => '',
            'fax'         => '',
            'email'       => '',
            'category_id' => 0,
            'sortord'     => 0,
            'ad_cate'     => 0,
            'ad_tag'      => 0,
            'long'        => '',
            'lat'         => '',
            'summary'     => '',
            'attention'   => '',
            'description' => '',
            'deleted_at'  => time(),
        ]);
    }

    /**
     * 解析查询条件
     *
     * @param array $condition 查询条件
     * @return Builder
     */
    protected static function parseCondition($condition)
    {
        return Model::when(isset($condition['withCategory']), function ($query) {
                return $query->with('category');
            })
            ->when(isset($condition['search']), function ($query) use ($condition) {
                return $query->where(function ($query) use ($condition) {
                    return $query
                        ->orWhere('name', 'like', "%{$condition['search']}%")
                        ->orWhere('contacts', 'like', "%{$condition['search']}%")
                        ->orWhere('telephone', 'like', "%{$condition['search']}%");
                });
            })
            ->when(isset($condition['category_id']), function ($query) use ($condition) {
                return $query->where('category_id', $condition['category_id']);
            })
            ->when(isset($condition['withTags']), function ($query) {
                return $query->with('tags');
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
    public static function getList($condition = [], $columns = ['*'], $paginate = true, $orderColumn = 'id', $orderDirection = 'desc')
    {
        $query = static::parseCondition($condition)
            ->orderBy($orderColumn, $orderDirection)
            ->select($columns);

        return $paginate ? $query->paginate() : $query->get();
    }

}
