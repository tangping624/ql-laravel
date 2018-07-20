<?php

namespace App\Extensions;

trait BeTagged
{
    /**
     * 关联拥有的标签
     */
    public function beTaggeds()
    {
        return $this->morphToMany('App\Models\Tag', 'be_tagged');
    }
}
