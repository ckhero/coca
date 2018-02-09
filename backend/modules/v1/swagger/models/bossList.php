<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="bossList"))
 */
class bossList
{

    /**
     * @SWG\Property(description="世界BOSS 列表")
     * @var boss[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
