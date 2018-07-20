<?php

namespace App\Repositories;

use App\Models\Product as Model;
use App\Models\Merchant;

use Auth;

class Product
{
    /**
     * 创建空信息产品
     *
     * @param  array $data
     * @param App\Models\Merchant $merchant
     * @return
     */
    public static function createEmpty(Merchant $merchant = null)
    {
        return Model::create([
            'admin_id'     => Auth::user()->id,
            'name'         => '',
            'merchant_id'  => $merchant ? $merchant->id : 0,
            'information'  => '',
            'introduction' => '',
            'deleted_at'   => time(),
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
        return Model::when(isset($condition['withMerchant']), function ($query) {
                return $query->with('merchant');
            })
            ->when(isset($condition['search']), function ($query) use ($condition) {
                return $query
                    ->join('merchants as ms', 'ms.id', 'products.merchant_id')
                    ->where(function ($query) use ($condition) {
                        return $query
                            ->orWhere('products.name', 'like', "%{$condition['search']}%")
                            ->orWhere('ms.name', 'like', "%{$condition['search']}%");
                    });
            })
            ->when(isset($condition['category_id']), function ($query) use ($condition) {
                return $query
                    ->join('merchants as mc', 'mc.id', 'products.merchant_id')
                    ->where('mc.category_id', $condition['category_id']);
            })
            ->when(isset($condition['merchant_id']), function ($query) use ($condition) {
                return $query->where('merchant_id', $condition['merchant_id']);
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
    public static function getList($condition = [], $columns = ['products.*'], $paginate = true, $orderColumn = 'id', $orderDirection = 'desc')
    {
        $query = static::parseCondition($condition)
            ->orderBy($orderColumn, $orderDirection)
            ->select($columns);

        return $paginate ? $query->paginate() : $query->get();
    }

}
