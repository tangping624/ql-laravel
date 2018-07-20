<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Repositories\Category as CategoryRepo;

use App\Models\Tag;
use App\Models\Image;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * 栏目首页
     *
     * @return view
     */
    public function index()
    {
        $cates = CategoryRepo::getList();

        return view('admin.category.index', compact('cates'));
    }

    /**
     * 栏目详情
     *
     * @param  Category $category
     * @return json
     */
    public function detail(Category $category)
    {
        $category->load('images')->load('tags');
        $category->icon = asset($category->icon());
        $category->tags->each(function ($item) {
            $item->icon = asset($item->icon());
        });

        return $category;
    }

    /**
     * 设置栏目显示
     *
     * @param  Category $category
     * @return
     */
    public function displayShow(Category $category)
    {
        $category->show();

        return ['status' => true];
    }

    /**
     * 设置栏目隐藏
     *
     * @param  Category $category
     * @return
     */
    public function displayHide(Category $category)
    {
        $category->hide();

        return ['status' => true];
    }

    /**
     * 设置栏目图片
     *
     * @param Category $category
     * @return
     */
    public function setIcon(Request $request, Category $category)
    {
        $image = Image::findOrFail($request->image_id);

        $icon = $category->setIcon($image);

        return ['status' => true, 'uri' => $icon];
    }

    /**
     * 更新栏目信息
     *
     * @param  Request  $request
     * @param  Category $category
     * @return
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            // 'path'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        $category->modify($request->name, $request->sortord, $request->image_id);

        return ['status' => true];
    }

    /**
     * 添加栏目分类
     *
     * @param  Request  $request
     * @param  Category $category
     * @return
     */
    public function tagCreate(Request $request, Category $category)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        $category->createTag($request->name, $request->sortord, $request->image_id);

        $category->load('tags');

        return ['status' => true, 'tags' => $category->tags];
    }


    /**
     * 更新 tag
     *
     * @param  Request  $request
     * @param  Category $category
     * @param  Tag      $tag
     * @return
     */
    public function tagUpdate(Request $request, Category $category, Tag $tag)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        $tag->modify($request->name, $request->sortord, $request->image_id);

        $category->load('tags');

        return ['status' => true, 'tags' => $category->tags];
    }
}
