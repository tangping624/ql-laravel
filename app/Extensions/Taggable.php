<?php

namespace App\Extensions;

use App\Models\Image;

use Auth;

trait Taggable
{
    /**
     * 关联拥有的标签
     */
    public function tags()
    {
        return $this
            ->morphMany('App\Models\Tag', 'taggable')
            ->orderBy('sortord', 'asc');
    }

    /**
     * 添加标签
     *
     * @param  string $name
     * @param  int $sortord
     * @param  int $imageId
     * @return App\Models\Tag
     */
    public function createTag($name, $sortord, $imageId)
    {
        $tag = $this->tags()->create([
            'admin_id'   => Auth::user()->id,
            'name'       => $name,
            'sortord'    => $sortord,
            'display'    => 1,
            'created_at' => time(),
        ]);

        if ($imageId && $image = Image::find($imageId)) {
            $tag->setIcon($image);
        }

        $tag->icon = asset($tag->icon());

        return $tag;
    }
}
