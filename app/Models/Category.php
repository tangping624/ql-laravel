<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Extensions\Taggable;
use App\Extensions\Imageable;

use App\Models\Image;

use Auth;

class Category extends Model
{
    use Imageable, Taggable;

    public    $timestamps = false;
    protected $dateFormat = 'U';
    protected $fillable   = ['name', 'type'];
    protected $hidden     = [
        'admin_id',
        'path',
        'sortord',
        'display',
        'type',
        'link_url',
        'created_at',
    ];

    protected $casts = [
        'display' => 'boolean',
    ];

    /**
     * 栏目显示查询作用域
     */
    public function scopeDisplay($query, $value = true)
    {
        return $query->where('display', $value);
    }

    /**
     * 设置栏目显示
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
     * 设置栏目隐藏
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
     * 栏目图标
     */
    public function icon()
    {
        return $this->imageCover();
    }

    /**
     * 设置栏目 icon
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
     * 更新栏目
     *
     * @param  string $name
     * @param  int $sortord
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
