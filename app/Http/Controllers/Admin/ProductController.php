<?php

namespace App\Http\Controllers\Admin;

use URL;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Image;
use App\Models\Product;

use App\Repositories\Product as ProductRepo;
use App\Repositories\Category as CategoryRepo;

class ProductController extends Controller
{
    /**
     * 产品管理首页
     *
     * @param  Request $requestj
     * @param  Merchant $merchant 商户
     * @param  boolean $inIframe 在 iframe 里显示
     * @return
     */
    public function index(Request $request, $merchant = null, $inIframe = false)
    {
        $condition = ['withMerchant' => true];
        if ($merchant) {
            $condition['merchant_id'] = $merchant->id;
        }
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

        $products = ProductRepo::getList($condition);
        $cates    = CategoryRepo::allMerchant()->pluck('name', 'id');

        return view('admin.product.index', compact('products', 'search', 'categoryId', 'cates', 'linkParams', 'merchant', 'inIframe'));
    }

    /**
     * 新建产品
     *
     * @param  Request $request
     * @param  Merchant $merchant 商户
     * @param  string $redirect
     * @return
     */
    public function create($merchant = null, $redirect = null)
    {
        $title = '新增产品';
        $action = 'create';
        $product = ProductRepo::createEmpty();
        $cates    = CategoryRepo::allMerchant()->pluck('name', 'id');
        $redirect = $redirect ?: route('admin.product.index');

        return view('admin.product.editor', compact('title', 'product', 'cates', 'action', 'merchant', 'redirect'));
    }

    /**
     * 新建产品
     *
     * @return [type] [description]
     */
    public function store(Request $request, Product $product)
    {
        $data = $request->only([
            'name',
            'merchant_id',
            'information',
            'introduction',
        ]);

        $cover1 = Image::find($request->cover1);
        $cover2 = Image::find($request->cover2);

        $product->new($data, array_filter($request->tag_id), $cover1, $cover2);

        return ['status' => true];
    }

    /**
     * 编辑产品
     *
     * @param  Product $product
     * @return
     */
    public function edit(Product $product, $merchant = null, $redirect = null)
    {
        $title    = '编辑产品';
        $action   = 'edit';
        $cates    = CategoryRepo::allMerchant()->pluck('name', 'id');
        $redirect = $redirect ?: route('admin.product.index');

        return view('admin.product.editor', compact('title', 'product', 'cates', 'action', 'merchant', 'redirect'));
    }

    /**
     * 更新产品信息
     *
     * @param  Product $product
     * @return
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->only([
            'name',
            'merchant_id',
            'information',
            'introduction',
        ]);

        $cover1 = Image::find($request->cover1);
        $cover2 = Image::find($request->cover2);

        $product->modify($data, array_filter($request->tag_id), $cover1, $cover2);

        return ['status' => true];
    }
}
