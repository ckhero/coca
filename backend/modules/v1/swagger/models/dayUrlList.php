<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="dayUrlList"))
 */
class dayUrlList
{

    /**
     * @SWG\Property(description="没人任务url列表")
     * @var dayUrl[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
