<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="refreshResult"))
 */
class refreshResult
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
}
