<?php

namespace App\Http\Controllers\Admin;

use URL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Tag;
use App\Models\Image;
use App\Models\Product;
use App\Models\Merchant;

use App\Repositories\Merchant as MerchantRepo;
use App\Repositories\Category as CategoryRepo;
use App\Repositories\Image as ImageRepo;
use App\Repositories\Product as ProductRepo;

class MerchantController extends Controller
{
    /**
     * 商户管理首页
     *
     * @param  Request $request
     * @return
     */
    public function index(Request $request)
    {
        $condition = ['withCategory' => true];
        $linkParams = [];

        if ($request->has('search')) {
            $condition['search'] = $search = $linkParams['search'] = $request->search;
        } else {
            $search = '';
        }

        if ($request->has('category')) {
            $condition['category_id'] = $categoryId = $linkParams['category'] = $request->category;
        } else {
            $categoryId = '';
        }

        $merchants = MerchantRepo::getList($condition);
        $cates     = CategoryRepo::allMerchant();

        return view('admin.merchant.index', compact('merchants', 'search', 'categoryId', 'cates', 'linkParams'));
    }

    /**
     * 新建商户
     *
     * @param  Request $request
     * @return
     */
    public function create()
    {

        $title    = '新增商户';
        $action   = 'create';
        $merchant = MerchantRepo::createEmpty();
        $cates    = CategoryRepo::allMerchant();
        $cateTags = [];
        foreach ($cates as $cate) {
            $cateTags[$cate->id] = $cate->tags->toArray();
        }
        $inProductTab = false;

        return view('admin.merchant.editor', compact('title', 'action', 'merchant', 'cates', 'cateTags', 'inProductTab'));
    }

    /**
     * 创建新商户
     *
     * @param  Request  $request
     * @param  Merchant $merchant
     * @return
     */
    public function store(Request $request, Merchant $merchant)
    {
        $data = $request->only([
            'category_id',
            'name',
            'contacts',
            'telephone',
            'fax',
            'email',
            'address',
            'long',
            'lat',
            'summary',
            'attention',
            'description',
        ]);

        $cover1 = Image::find($request->cover1);
        $cover2 = Image::find($request->cover2);

        $merchant->new($data, array_filter($request->tag_id), $cover1, $cover2);

        return ['status' => true];
    }

    /**
     * 编辑商户
     *
     * @param  Merchant $merchant
     * @return
     */
    public function edit(Request $request, Merchant $merchant)
    {
        $title    = '编辑商户';
        $action   = 'edit';
        $cates    = CategoryRepo::allMerchant();
        $cateTags = [];
        foreach ($cates as $cate) {
            $cateTags[$cate->id] = $cate->tags->toArray();
        }
        $merchant->load('images');
        $inProductTab = 'product' == $request->input('tab', '');

        return view('admin.merchant.editor', compact('title', 'action', 'merchant', 'cates', 'cateTags', 'inProductTab'));
    }

    /**
     * 更新商户信息
     *
     * @param  Merchant $merchant [description]
     * @return [type]             [description]
     */
    public function update(Request $request, Merchant $merchant)
    {
        $data = $request->only([
            'category_id',
            'name',
            'contacts',
            'telephone',
            'fax',
            'email',
            'address',
            'long',
            'lat',
            'summary',
            'attention',
            'description',
        ]);

        $cover1 = Image::find($request->cover1);
        $cover2 = Image::find($request->cover2);

        $merchant->modify($data, array_filter($request->tag_id), $cover1, $cover2);

        return ['status' => true];
    }

    /**
     * 设置图片排序
     *
     * @param  Merchant $merchant
     * @param  Image    $image
     * @return
     */
    public function imageSetSortord(Request $request, Merchant $merchant, Image $image)
    {
        $sortord = $merchant->setImageSortord($image, (int)$request->input('sortord', 0));

        return ['status' => true, 'images' => $merchant->rollImages()];
    }

    /**
     * 图片上传
     *
     * @param  Request  $request
     * @param  Merchant $merchant
     * @return
     */
    public function imageUpload(Request $request, Merchant $merchant)
    {
        $file = $request->file('image');

        if (!$file->isValid()) {
            return ['status' => false, 'msg' => '上传失败'];
        }

        $merchant->imageUpload($file);

        return ['status' => true, 'images' => $merchant->rollImages()];
    }

    /**
     * 新增 tag
     *
     * @param  Request  $request
     * @param  Merchant $merchant
     * @return [type]
     */
    public function tagCreate(Request $request, Merchant $merchant)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        $merchant->createTag($request->name, $request->sortord, $request->image_id);

        $merchant->load('tags');

        return ['status' => true, 'tags' => $merchant->tags];
    }

    /**
     * 更新 tag
     *
     * @param  Request  $request
     * @param  Merchant $merchant
     * @param  Tag      $tag
     * @return
     */
    public function tagUpdate(Request $request, Merchant $merchant, Tag $tag)
    {
        $this->validate($request, [
            'name'     => 'required|max:255',
            'sortord'  => 'required|numeric',
            'image_id' => 'required|numeric',
        ]);

        $tag->modify($request->name, $request->sortord, $request->image_id);

        $merchant->load('tags');

        return ['status' => true, 'tags' => $merchant->tags];
    }

    /**
     * 商户创建产品
     *
     * @param  Merchant $merchant
     * @return
     */
    public function productCreate(Merchant $merchant)
    {
        return app(ProductController::class)->create($merchant, route('admin.merchant.edit', ['merchant' => $merchant, 'tab' => 'product']));
    }

    /**
     * 产品列表
     *
     * @param  Request $request
     * @param  Merchant $merchant
     * @return
     */
    public function productList(Request $request, Merchant $merchant)
    {
        return app(ProductController::class)->index($request, $merchant, true);
    }

    /**
     * 商户编辑产品
     *
     * @param  Merchant $merchant
     * @param  Product  $product
     * @return
     */
    public function productEdit(Merchant $merchant, Product $product)
    {
        return app(ProductController::class)->edit($product, $merchant, route('admin.merchant.edit', ['merchant' => $merchant, 'tab' => 'product']));
    }

    /**
     * 搜索 ajax 结果
     *
     * @param  Request $request
     * @return json
     */
    public function search(Request $request)
    {
        $condition = [
            'withCategory' => true,
            'withTags'     => true,
        ];

        if ($request->has('search')) {
            $condition['search'] = $request->search;
        }

        if ($request->has('category') && $request->category != 0) {
            $condition['category_id'] = $request->category;
        }

        $merchants = MerchantRepo::getList($condition, ['*'], false);

        return $merchants;
    }
}
