<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Merchant as MerchantRepo;

class CategoryController extends Controller
{
    //
    public function path($catePath)
    {
        $category = Category::where('path', $catePath)->firstOrFail();
        
        $condition['category_id'] = $category->id;
        
        $merchants = MerchantRepo::getList($condition);
        //dump($merchants);
        //$merchant = $merchants->first();
        //dump($merchant->path);exit;
        //dump($merchant->cover(1)->uri);
        //dump($merchant->cover(2));
       /*  foreach ($merchants as $merchant) {
            print_r($merchant->name);exit;
        } */
        
        return view('home.category', ['category' => $category,'merchants' => $merchants]);
        //echo $category->name;
    }
}
