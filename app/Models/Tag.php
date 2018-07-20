<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Extensions\Imageable;

use App\Models\Image;

class Tag extends Model
{
    use Imageable;

    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = [];
    protected $dates = ['created_at'];
    protected $hidden = ['admin_id', 'created_at', 'taggable_id', 'taggable_type'];

    protected $casts = [
        'display' => 'boolean',
    ];

    /**
     * 多态关联
     */
    public function taggable()
    {
        return $this->morphTo();
    }

    /**
     * 标签对应的产品关联
     */
    public function products()
    {
        return $this->morphedByMany('App\Models\Product', 'be_tagged');
    }

    /**
     * 标签显示查询作用域
     */
    public function scopeDisplay($query, $value = true)
    {
        return $query->where('display', $value);
    }

    /**
     * 设置标签显示
     *
     * @return true
     */
    public function show()
    {
        $this->display = true;
        $this->save();

        return true;
    }

    /**
     * 设置标签隐藏
     *
     * @return boolean
     */
    public function hide()
    {
        $this->display = false;
        $this->save();

        return true;
    }

    /**
     * 标签图标
     */
    public function icon()
    {
        return $this->imageCover();
    }

    /**
     * 设置栏目标签 icon
     *
     * @param Image $image [description]
     */
    public function setIcon(Image $image)
    {
        // 如果包含 icon，将其删除
        if ($this->images->count()) {
            $this->images->first()->delete();
        }

        // 保存新的图片作为 icon
        $this->images()->save($image);
        $this->load('images');

        $this->imageClearCache();

        return $this->icon();
    }

    /**
     * 更新标签
     *
     * @param  string $name
     * @param  string $sortord
     * @param  int $imageId
     * @return
     */
    public function modify($name, $sortord, $imageId)
    {
        $this->name    = $name;
        $this->sortord = $sortord;
        $this->save();

        if ($imageId && $image = Image::find($imageId)) {
            $this->setIcon($image);
        }

        return $this;
    }
}
