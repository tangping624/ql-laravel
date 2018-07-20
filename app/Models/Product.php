<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Extensions\Coverable;
use App\Extensions\BeTagged;

use Cache;

class Product extends Model
{
    use SoftDeletes, Coverable, BeTagged;

    const IMAGE_TYPE_COVER_1 = 1;
    const IMAGE_TYPE_COVER_2 = 2;

    protected $dateFormat = 'U';
    protected $guarded    = ['id', 'created_at', 'updated_at'];
    protected $dates      = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * 关联商户
     */
    public function merchant()
    {
        return $this->belongsTo('App\Models\Merchant');
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
     * 新建产品
     *
     * @param  array $data 产品数据
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
     * 编辑产品
     *
     * @param  array $data 产品数据
     * @param  array $beTaggedIds 标签 Id
     * @param  App\Models\Image $cover1 封面图片1
     * @param  App\Models\Image $cover2 封面图片2
     * @return true
     */
    public function modify($data, $beTaggedIds, $cover1, $cover2)
    {
        // 基础数据
        $this->merchant_id = $data['merchant_id'];
        $this->name        = $data['name'];
        isset($data['information'])    && $this->information    = $data['information'];
        isset($data['introduction'])   && $this->introduction   = $data['introduction'];
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
}
