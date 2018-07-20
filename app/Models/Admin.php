<?php

namespace App\Models;

use Auth;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

use App\Exceptions\Admin\AdminPasswordException;
use App\Exceptions\Admin\AdminAuthorityException;

class Admin extends Authenticatable
{
    use SoftDeletes;

    protected $dateFormat = 'U';
    protected $fillable   = ['name', 'password'];
    protected $hidden     = ['password', 'remember_token'];
    protected $dates      = ['deleted_at', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        // 添加管理员状态全局作用域
        static::addGlobalScope('status', function (Builder $builder) {
            $builder->where('admins.status', 1);
        });
    }

    /**
     * 修改密码
     *
     * @param string $original 原始密码
     * @param string $new 新密码
     * @param string cofirm 新密码确认
     * @return true
     */
    public function passwordChange($original, $new, $confirm)
    {
        if (!Auth::guard()->attempt(['name' => $this->name, 'password' => $original])) {
            throw new AdminPasswordException('原始密码错误', 'original');
        }

        if (strlen($new) < 8  || (preg_match('/[0-9].*([a-zA-Z].*[a-zA-Z])|[a-zA-Z].*([0-9].*[0-9])|([0-9].*[a-zA-Z]|[a-zA-Z].*[0-9])/', $new) == 0)) {
            throw new AdminPasswordException('必须是 8 位或以上数字+字母组合', 'new');
        }

        if ($new !== $confirm) {
            throw new AdminPasswordException('两次密码输入不一致', 'confirm');
        }

        $this->password = bcrypt($new);
        $this->save();

        return true;
    }

    /**
     * 重置密码
     *
     * @return boolean
     */
    public function passwordReset()
    {
        if ($this->id == 1 || $this->id == Auth::user()->id) {
            throw new AdminAuthorityException;
        }

        $this->password = bcrypt('00000000');
        $this->save();

        return true;
    }

    /**
     * 启用管理员
     *
     * @return true
     */
    public function enable()
    {
        if ($this->id == 1 || $this->id == Auth::user()->id) {
            throw new AdminAuthorityException;
        }

        $this->status = 1;
        $this->save();

        return true;

    }


    /**
     * 停用管理员
     *
     * @return true
     */
    public function disable()
    {
        if ($this->id == 1 || $this->id == Auth::user()->id) {
            throw new AdminAuthorityException;
        }

        $this->status = 2;
        $this->save();

        return true;

    }
}
