<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Extensions\BeTagged;
use App\Extensions\Taggable;
use App\Extensions\Coverable;

use App\Repositories\Image as ImageRepo;

use App\Models\Image;

use Cache;

use APP\Exceptions\Merchant\MerchantImageException;

class Merchant extends Model
{
    use SoftDeletes, Coverable, Taggable, BeTagged;

    const IMAGE_TYPE_ROLL    = 1;
    const IMAGE_TYPE_COVER_1 = 2;
    const IMAGE_TYPE_COVER_2 = 3;

    protected $dateFormat = 'U';
    protected $guarded    = ['id', 'created_at', 'updated_at'];
    protected $dates      = ['deleted_at', 'created_at', 'updated_at'];
    protected $hidden     = [
        'admin_id',
        'status',
        'category_id',
        'sortord',
        'fax',
        'email',
        'address',
        'long',
        'lat',
        'summary',
        'attention',
        'description',
        'pv',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * 状态查询作用域
     */
    public function scopeStatus($query, $value = 1)
    {
        return $query->where('status', $value);
    }

    /**
     * 栏目关联
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * 产品关联
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    /**
     * 新建商户
     *
     * @param  array $data 商户数据
     * @param  array $beTaggedIds
     * @param  App\Models\Image $cover1 封面图片1
     * @param  App\Models\Image $cover2 封面图片2
     * @return true
     */
    public function new($data, $beTaggedIds, $cover1, $cover2)
    {
        $this->deleted_at = null;
        $this->modify($data, $beTaggedIds, $cover1, $cover2);

        return true;
    }

    /**
     * 编辑商户
     *
     * @param  array $data 商户数据
     * @param  array $beTaggedIds 栏目标签 Id
     * @param  App\Models\Image $cover1 封面图片1
     * @param  App\Models\Image $cover2 封面图片2
     * @return true
     */
    public function modify($data, $beTaggedIds, $cover1, $cover2)
    {
        // 基础数据
        $this->category_id = $data['category_id'];
        $this->name        = $data['name'];
        isset($data['contacts'])    && $this->contacts    = $data['contacts'];
        isset($data['telephone'])   && $this->telephone   = $data['telephone'];
        isset($data['fax'])         && $this->fax         = $data['fax'];
        isset($data['email'])       && $this->email       = $data['email'];
        isset($data['address'])     && $this->address     = $data['address'];
        isset($data['long'])        && $this->long        = $data['long'];
        isset($data['lat'])         && $this->lat         = $data['lat'];
        isset($data['summary'])     && $this->summary     = $data['summary'];
        isset($data['attention'])   && $this->attention   = $data['attention'];
        isset($data['description']) && $this->description = $data['description'];
        $this->save();

        // 同步 tag
        $this->beTaggeds()->sync($beTaggedIds);

        // 处理封面1
        if ($this->cover(1)->id != $cover1->id) {
            $this->cover(1)->delete();
            $cover1->type = static::IMAGE_TYPE_COVER_1;
            $this->images()->save($cover1);
            Cache::forget($this->imageCacheKey('_cover1'));
        }

        // 处理封面2
        if ($this->cover(2)->id != $cover2->id) {
            $this->cover(2)->delete();
            $cover2->type = static::IMAGE_TYPE_COVER_2;
            $this->images()->save($cover2);
            Cache::forget($this->imageCacheKey('_cover2'));
        }

        return true;
    }

    /**
     * 图片上传
     *
     * @param  $file
     * @return App\Models\Image
     */
    public function imageUpload($file)
    {
        $image = ImageRepo::upload($file);

        $this->images()->save($image);

        Cache::forget($this->imageCacheKey('_roll_uris'));
        $this->load('images');

        return $image;
    }

    /**
     * 设置图片排序
     *
     * @param Image  $image
     * @param int $sortord
     */
    public function setImageSortord(Image $image, $sortord)
    {
        $image->sortord = $sortord;
        $image->save();

        Cache::forget($this->imageCacheKey('_roll_uris'));
        $this->load('images');

        return $sortord;
    }

    /**
     * 根据 cover 编号获取 imageType
     *
     * @param  int $coverNum
     * @return int
     */
    public function imageType($coverNum)
    {
        switch ($coverNum) {
            default:
                throw new MerchantImageException('封面编号错误');
                break;
            case 1:
                $imageType = static::IMAGE_TYPE_COVER_1;
                break;
            case 2:
                $imageType = static::IMAGE_TYPE_COVER_2;
                break;
        }

        return $imageType;
    }

    /**
     * 获取轮播图片列表
     *
     * @return
     */
    public function rollImages()
    {
        return $this->images->where('type', static::IMAGE_TYPE_ROLL)->values();
    }

    /**
     * 获取轮播图 uri
     *
     * @return
     */
    public function rollUris()
    {
        return Cache::rememberForever(
            $this->imageCacheKey('_roll_uris'),
            function () {
                $images = $this->images->where('type', static::IMAGE_TYPE_ROLL);

                return $images->pluck('uri');
            }
        );
    }
}
