<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * 加入默认图片数据
     *
     * @return void
     */
    public function run()
    {
        $file = public_path(config('misc.default-image'));

        if (file_exists($file)) {
            $fi = new \finfo(FILEINFO_MIME_TYPE);
            $imageSize = getimagesize($file);

            \DB::table('images')->insert([
                'user_id'        => 0,
                'user_class'     => 'system',
                'md5'            => md5_file($file),
                'mime'           => $fi->file($file),
                'uri'            => config('misc.default-image'),
                'width'          => $imageSize[0],
                'height'         => $imageSize[1],
                'size'           => filesize($file),
                'imageable_id'   => 0,
                'imageable_type' => 'system',
                'created_at'     => time(),
            ]);
        }
    }
}
