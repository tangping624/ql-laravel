<?php

namespace App\Repositories;

use App\Models\Admin as Model;

use App\Exceptions\Admin\AdminCreateException;
use App\Exceptions\Admin\AdminPasswordException;

class Admin
{
    /**
     * 解析查询条件
     *
     * @param array $condition 查询条件
     * @return Builder
     */
    protected static function parseCondition($condition)
    {
        return Model::when(isset($condition['name']), function ($query) use ($condition) {
                return $query->where('name', 'like', "%{$condition['name']}%");
            })
            ->when(isset($condition['withoutScopeStatus']), function ($query) use ($condition) {
                return $query->withoutGlobalScope('status');
            });
    }

    /**
     * 获取管理员列表
     *
     * @param array $condition 查询条件
     * @param array $columns 查询字段
     * @param boolean $paginate 是否使用分页
     * @param string $orderColumn 排序列
     * @param string $orderDirection 排序方向
     * @return
     */
    public static function getList($condition = [], $columns = ['*'], $paginate = true, $orderColumn = 'id', $orderDirection = 'asc')
    {
        $query = static::parseCondition($condition)
            ->orderBy($orderColumn, $orderDirection)
            ->select($columns);

        return $paginate ? $query->paginate() : $query->get();
    }

    /**
     * 创建新的管理员
     *
     * @param  string $name     管理员名称
     * @param  string $password 登陆密码
     * @param  string $confirm  登陆密码确认
     * @return boolean
     */
    public static function create($name, $password, $confirm)
    {
        if (empty($name)) {
            throw new AdminCreateException('管理员名称不能为空', 'name');
        }

        if (Model::where('name', $name)->count()) {
            throw new AdminCreateException('管理员名称已经存在', 'name');
        }

        if (strlen($password) < 8  || (preg_match('/[0-9].*([a-zA-Z].*[a-zA-Z])|[a-zA-Z].*([0-9].*[0-9])|([0-9].*[a-zA-Z]|[a-zA-Z].*[0-9])/', $password) == 0)) {
            throw new AdminPasswordException('必须是 8 位或以上数字+字母组合', 'password');
        }

        if ($password !== $confirm) {
            throw new AdminPasswordException('两次密码输入不一致', 'confirm');
        }

        return Model::create([
            'name' => $name,
            'password' => bcrypt($password),
        ]);
    }
}
