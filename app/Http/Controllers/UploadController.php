<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Repositories\Image as ImageRepo;

class UploadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:,admin');
    }

    /**
     * 上传图片
     *
     * @return App\Models\Image
     */
    public function image(Request $request)
    {
        $file = $request->file('image');

        if (!$file->isValid()) {
            return ['status' => false, 'msg' => '上传失败'];
        }

        $image = ImageRepo::upload($file);

        return [
            'status' => true,
            'id'     => $image->id,
            'uri'    => $image->uri,
            'image'  => [
                'width'  => $image->width,
                'height' => $image->height,
            ],
        ];
    }

    /**
     * ueditor 上传图片不加入数据库，单独放一个目录
     *
     * @param  Request $request
     * @return
     */
    public function ueditor(Request $request)
    {
        if (!$request->has('action')) {
            abort(404);
        }

        switch($request->action) {
            default:
                abort(404);
                break;
            case 'config': // ueditor 获取配置，必须存在
                $result =  config('ueditor');
                break;
            case 'uploadimage': // 上传图片
                $file = $request->file('upfile');

                if (!$file->isValid()) {
                    return ['status' => false, 'msg' => '上传失败'];
                }

                // 生成文件名
                do {
                    $hashName = Str::random(40) . '.' . $file->guessExtension();
                    $path = 'article/' . substr($hashName, 0, 2) . '/' . substr($hashName, 2, 2) . '/' . substr($hashName, 4, 2);
                    $filename = substr($hashName, 6);
                    $fullName = $path . '/' . $filename;
                    $realPath = storage_path('app/public/' . $fullName);
                } while (file_exists($realPath)); // 如果文件存在，重新生成文件名

                $file->storeAs('public/' . $path, $filename); // 存储文件

                $result = [
                    'original' => $file->getClientOriginalName(),
                    'size'     => getimagesize($realPath),
                    'state'    => 'SUCCESS',
                    'title'    => $filename,
                    'type'     => $file->getClientOriginalExtension(),
                    'url'      => asset('storage/' . $fullName),
                ];
                break;
        }

        return $result;
    }
}
