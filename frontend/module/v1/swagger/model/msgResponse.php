<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="msgResponse"))
 */
class msgResponse
{

    /**
     * @SWG\Property(description="消息列表")
     * @var _msg[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
