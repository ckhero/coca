<?php

/**
 * @SWG\Definition(required={}, type="object", @SWG\Xml(name="user"))
 */
class user
{

    /**
     * @SWG\Property(description="用户的可乐id")
     * @var int
     */
    private $coca_id;

    /**
     * @SWG\Property(description="积分")
     * @var int
     */
    private $point;

    /**
     * @SWG\Property(description="排名")
     * @var int
     */
    private $rank;
    /**
     * pet status in the store
     * @SWG\Property( description="头像")
     * @var string
     */
    private $head_img;

    /**
     * pet status in the store
     * @SWG\Property( description="昵称")
     * @var string
     */
    private $nick_name;
}
