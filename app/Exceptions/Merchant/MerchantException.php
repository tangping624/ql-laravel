<?php

namespace App\Exceptions\Merchant;

use Exception;

/**
 * 商户异常
 */
class MerchantException extends Exception
{
    public function __construct($message = '商户错误')
    {
        parent::__construct($message);
    }
}
