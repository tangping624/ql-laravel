<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;

class Image extends Model
{
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = [];
    protected $dates = ['created_at'];

    // json 可见属性
    protected $visible = ['id', 'uri', 'width', 'height', 'size', 'type', 'sortord'];

    /**
     * 多态关联
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    /**
     * 类型查询作用域
     */
    public function scopeType($query, $value = 1)
    {
        return $query->where('type', $value);
    }

    /**
     * 删除图片
     */
    public function destory()
    {
        Storage::delete(str_replace('storage', 'public', $this->uri));

        return $this->delete();
    }

    /**
     * 设置图片类型
     *
     * @param int $type
     * @return App\Models\Image
     */
    public function setType($type)
    {
        $this->type = $type;
        $this->save();

        return $this;
    }
}
