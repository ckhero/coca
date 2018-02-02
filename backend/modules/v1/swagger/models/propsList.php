<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="propsList"))
 */
class propsList
{

    /**
     * @SWG\Property(description="道具列表")
     * @var props[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
