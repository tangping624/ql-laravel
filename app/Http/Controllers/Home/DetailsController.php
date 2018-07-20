<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchant;

class DetailsController extends Controller
{
    //
    public function path(Merchant $merchant)
    {
        $rollImage = $merchant->rollImages();

        $images = $rollImage->map(function($image) {
            return [
            	'url' => asset($image->uri),
                'width' => $image->width,
                'height' => $image->height,
            ];
        });
        
        $string = $images->toJson();
        
        return view('home.details', ['details' => $merchant,'string' => $string]);
        
    }
}
