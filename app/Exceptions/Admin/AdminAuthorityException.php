<?php

namespace App\Exceptions\Admin;

/**
 * 管理员权限异常
 */
class AdminAuthorityException extends AdminException
{
    public function __construct($message = '没有权限')
    {
        parent::__construct($message);
    }
}
