<?php

namespace App\Models\Observers;

use App\Models\Image as Model;

use Storage;

class Image
{
    /**
     * 监听图片删除事件
     *
     * @param App\Models\Image $image
     * @return void
     */
    public function deleting(Model $image)
    {
        // 禁止删除用户类型为 class 的默认图片
        if ($image->user_class == 'system') {
            return false;
        }

        // 删除图片文件
        Storage::delete(str_replace('storage/', 'public/', $image->uri));
    }
}
