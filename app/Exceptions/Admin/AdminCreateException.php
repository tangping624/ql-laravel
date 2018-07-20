<?php

namespace App\Exceptions\Admin;

/**
 * 管理员更改密码异常
 */
class AdminCreateException extends AdminException
{
    protected $field;

    public function __construct($message = '管理员创建错误', $field = '')
    {
        parent::__construct($message);

        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }
}
