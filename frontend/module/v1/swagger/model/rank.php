<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="rank"))
 */
class rank
{

    /**
     * @SWG\Property(description="小关卡列表")
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
