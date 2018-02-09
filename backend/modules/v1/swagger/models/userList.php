<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="mapsList"))
 */
class userList
{

    /**
     * @SWG\Property(description="用户列表")
     * @var user[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
