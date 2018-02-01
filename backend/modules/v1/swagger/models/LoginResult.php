<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LoginResult"))
 */
class LoginResult
{

     /**
     * @SWG\Property(description="验证令牌", example="KWhifzC_QTLNXwcuccCclGJQ3p9MtkWB")
     * @var string
     */
    private $access-token;

    /**
     * @SWG\Property(description="令牌过期时间，单位秒", example="3600")
     * @var int
     */
    private  $expire-time;
}
