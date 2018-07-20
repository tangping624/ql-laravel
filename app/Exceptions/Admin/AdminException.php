<?php

namespace App\Exceptions\Admin;

use Exception;

/**
 * 管理员异常
 */
class AdminException extends Exception
{
    public function __construct($message = '管理员异常')
    {
        parent::__construct($message);
    }
}
