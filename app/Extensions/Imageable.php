<?php

namespace App\Extensions;

use Cache;

trait Imageable
{
    /**
     * 关联图片
     */
    public function images()
    {
        return $this
            ->morphMany('App\Models\Image', 'imageable')
            ->orderBy('sortord', 'asc');
    }

    /**
     * 封面图片
     *
     * @return string 图片 uri
     */
    public function imageCover()
    {
        return Cache::rememberForever(
            $this->imageCacheKey('_cover'), // 缓存的 key
            function () {
                return $this->images->count() ? $this->images[0]->uri : $this->imageDefault();
            }
        );
    }

    /**
     * 默认图片
     */
    public function imageDefault()
    {
        return config('misc.default-image');
    }

    /**
     * 缓存 key
     *
     * @param string $suffix 后缀
     * @return string
     */
    public function imageCacheKey($suffix = '')
    {
        return '_image_' . static::class . ($suffix ?: '') . '_' . $this->id;
    }

    /**
     * 清除缓存
     */
    public function imageClearCache()
    {
        Cache::forget($this->imageCacheKey('_cover'));
    }
}
