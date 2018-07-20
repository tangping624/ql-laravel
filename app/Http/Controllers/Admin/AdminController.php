<?php

namespace App\Http\Controllers\Admin;

use Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Exceptions\Admin\AdminException;

use App\Models\Admin;

use App\Repositories\Admin as AdminRepo;

class AdminController extends Controller
{
    /**
     * 管理员列表
     *
     * @param  Request $request
     * @return view
     */
    public function index(Request $request)
    {
        $condition = ['withoutScopeStatus' => true];

        if ($request->has('search')) {
            $condition['name'] = $search = $request->search;
        } else {
            $search = '';
        }

        $admins = AdminRepo::getList($condition);

        return view('admin.admin.index', compact('admins', 'search'));
    }

    /**
     * 创建新管理员
     *
     * @param  Request $request
     * @return view
     */
    public function create(Request $request)
    {
        try {
            AdminRepo::create(
                $request->input('name'),
                $request->input('password'),
                $request->input('confirm')
            );
        } catch (AdminException $e) {
            return ['status' => false, 'msg' => $e->getMessage(), 'field' => $e->getField()];
        }

        return ['status' => true];
    }

    /**
     * 更改密码
     *
     * @param  Request $request
     * @return json
     */
    public function passwordChange(Request $request)
    {
        try {
            Auth::user()
                ->passwordChange(
                    $request->input('original'),
                    $request->input('new'),
                    $request->input('confirm')
                );
        } catch (AdminException $e) {
            return ['status' => false, 'msg' => $e->getMessage(), 'field' => $e->getField()];
        }

        return ['status' => true];
    }

    /**
     * 重置密码
     *
     * @param  Admin  $admin
     * @return
     */
    public function passwordReset(Admin $admin)
    {
        $admin->passwordReset();

        return ['status' => true];
    }

    /**
     * 启用管理员
     *
     * @param  Admin  $admin
     * @return
     */
    public function enable(Admin $admin)
    {
        $admin->enable();

        return ['status' => true];
    }

    /**
     * 停用管理员
     *
     * @param  Admin $admin
     * @return
     */
    public function disable(Admin $admin)
    {
        $admin->disable();

        return ['status' => true];
    }

    /**
     * 删除管理员
     *
     * @param  int  $adminId
     * @return
     */
    public function destory(int $adminId)
    {
        $admin = Admin::withoutGlobalScope('status')->findOrFail($adminId);
        $admin->delete();

        return ['status' => true];
    }
}
