<?php

namespace App\Extensions;

use Cache;

use App\Models\Image;

trait Coverable
{
    use Imageable;

    /**
     * 获取封面图片
     *
     * @param  int $coverNum 封面图片编号
     * @return App\Models\Image
     */
    public function cover($coverNum)
    {
        $imageType = $this->imageType($coverNum);

        return Cache::rememberForever(
            $this->imageCacheKey('_cover' . $coverNum),
            function () use ($imageType) {
                return $this->images->where('type', $imageType)->first() ?: Image::find(1);
            }
        );
    }

    /**
     * 根据 cover 编号获取 imageType
     * 需要在具体的类里实现
     *
     * @param  int $coverNum
     * @return int
     */
    abstract public function imageType($coverNum);
}
