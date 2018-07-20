<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //前台首页
    public function index()
    {   
        $condition['withScopeDisplay'] = true;
        
        $cates = \App\Repositories\Category::getlist($condition);
        //var_dump(compact('cates'));exit;
        
        return view('home.index', compact('cates'));
    }
}
