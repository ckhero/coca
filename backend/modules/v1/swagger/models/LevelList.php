<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="LevelList"))
 */
class LevelList
{

    /**
     * @SWG\Property(description="等级列表")
     * @var Level[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
