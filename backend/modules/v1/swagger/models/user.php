<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="user"))
 */
class user
{

    /**
     * @SWG\Property(description="用户id", example="1")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="可乐的用户id", example="11111")
     * @var int
     */
    private $coca_id;

    /**
     * @SWG\Property(description="昵称", example="test")
     * @var string
     */
    private $nick_name;

    /**
     * @SWG\Property(description="头像地址", example="http://img0.imgtn.bdimg.com/it/u=12867320,655225767")
     * @var string
     */
    private $head_img;


    /**
     * @SWG\Property(description="积分", example="11")
     * @var int
     */
    private $points;

    /**
     * @SWG\Property(description="经验值", example="212")
     * @var int
     */
    private $exp;

    /**
     * @SWG\Property(description="可以玩小游戏的次数", example="12")
     * @var int
     */
    private $nog;

    /**
     * @SWG\Property(description="用户状态 0 为锁定，1为激活", example="0", enum={0, 1})
     * @var int
     */
    private $status;

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
     * @SWG\Property(description="refresh_token过期时间", example="3600 *24")
     * @var int
     */
    private $refresh_expired;
}
