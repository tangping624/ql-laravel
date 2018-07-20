<?php

namespace App\Repositories;

use App\Models\Image as Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

use Auth;
use Storage;

class Image
{
    /**
     * 上传图片
     *
     * @param Illuminate\Http\UploadedFile $file 上传文件
     * @return App\Models\Image
     */
    public static function upload(UploadedFile $file)
    {
        $user = Auth::user();

        // 生成文件名
        do {
            $hashName = Str::random(40) . '.' . $file->guessExtension();
            $path = 'up/' . substr($hashName, 0, 2) . '/' . substr($hashName, 2, 2) . '/' . substr($hashName, 4, 2);
            $filename = substr($hashName, 6);
            $fullName = $path . '/' . $filename;
            $realPath = storage_path('app/public/' . $fullName);
        } while (file_exists($realPath)); // 如果文件存在，重新生成文件名

        $file->storeAs('public/' . $path, $filename);

        $imageSize = getimagesize($realPath);

        return Model::create([
            'user_id'    => $user ? $user->id : 0,
            'user_class' => get_class($user),
            'md5'        => md5_file($realPath),
            'mime'       => $file->getMimeType(),
            'uri'        => 'storage/' . $fullName,
            'width'      => $imageSize[0],
            'height'     => $imageSize[1],
            'size'       => $file->getClientSize(),
            'created_at' => time(),
        ]);
    }

    /**
     * 根据 id 获取图片
     *
     * @param array $ids
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getByIds($ids)
    {
        if (!is_array($ids)) {
            $ids = [$ids];
        }

        return Model::whereIn('id', $ids)->get();
    }

    /**
     * 删除多个图片
     *
     * @param Illuminate\Database\Eloquent\Collection $images
     */
    public static function destory($images)
    {
        // 删除图片文件
        Storage::delete(
            $images
                ->pluck('uri')
                ->map(function ($item) {
                    return str_replace('storage/', 'public/', $item);
                })
                ->toArray()
        );

        return Model::whereIn('id', $images->pluck('id'))->delete();
    }
}
