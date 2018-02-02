<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="mapsList"))
 */
class mapsList
{

    /**
     * @SWG\Property(description="地图列表")
     * @var maps[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
