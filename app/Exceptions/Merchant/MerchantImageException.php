<?php

namespace App\Exceptions\Merchant;

/**
 * 商户图片异常
 */
class MerchantImageException extends MerchantException
{
    public function __construct($message = '商户图片错误')
    {
        parent::__construct($message);
    }
}
