<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="loginResult"))
 */
class loginResult
{

    /**
     * @SWG\Property(description="登陆令牌", example="K0CddrjOrwvjGCM2M26sPMMnbMC4B-E-")
     * @var string
     */
    private $access_token;

    /**
     * @SWG\Property(description="access_token过期时间", example="3600")
     * @var int
     */
    private $access_expired;

    /**
     * @SWG\Property(description="刷新 登陆令牌用的", example="gxjQEbrUYWqV9DXNh84OQI8mAdPBNiT0")
     * @var string
     */
    private $refresh_token;

    /**
     * @SWG\Property(description="refresh_token过期时间", example="3600")
     * @var int
     */
    private $refresh_expired;
}
