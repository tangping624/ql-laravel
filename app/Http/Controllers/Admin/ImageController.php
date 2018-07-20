<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Image;

class ImageController extends Controller
{
    /**
     * 删除图片
     *
     * @param  Image  $image
     * @return
     */
    public function delete(Image $image)
    {
        $image->delete();

        return ['status' => true];
    }
}
