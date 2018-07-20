<?php

namespace App\Models\Observers;

use App\Models\Tag as Model;

class Tag
{
    /**
     * 监听图片删除事件
     *
     * @param App\Models\Image $image
     * @return void
     */
    public function deleting(Model $tag)
    {
        // 删除图片
        foreach ($tag->images as $image) {
            $image->delete();
        }
    }
}
