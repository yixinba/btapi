<?php

declare(strict_types=1);

namespace yixinba\Bt\Exceptions;

use Exception;

class BtException extends Exception
{
    protected static $errors = [
        '101' => '请设置宝塔请求地址',
        '102' => '请设置宝塔请求密钥',
    ];

    public function __construct($code)
    {
        parent::__construct(self::$errors[$code], $code);
    }
}
 
