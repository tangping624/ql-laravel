<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tag;

class TagController extends Controller
{
    /**
     * 获取 tag 详情
     *
     * @param  App\Models\Tag  $tag
     * @return App\Models\Tag  $tag
     */
    public function detail(Tag $tag)
    {
        $tag->icon = asset($tag->icon());

        return $tag;
    }

    /**
     * 更新 tag
     *
     * @param  Request $request
     * @param  Tag     $tag
     * @return
     */
    public function update(Request $request, Tag $tag)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        return ['status' => true, 'tag' => $tag->modify($request->name, $request->sortord, $request->image_id)];
    }

    /**
     * 设置 tag 隐藏
     *
     * @param  Tag $tag
     * @return
     */
    public function displayHide(Tag $tag)
    {
        $tag->hide();

        return ['status' => true];
    }

    /**
     * 设置 tag 显示
     *
     * @param  Tag $tag
     * @return
     */
    public function displayShow(Tag $tag)
    {
        $tag->show();

        return ['status' => true];
    }

    /**
     * 删除 tag
     *
     * @param  Tag    $tag
     * @return
     */
    public function destory(Tag $tag)
    {
        $tag->delete();

        return ['status' => true];
    }
}
