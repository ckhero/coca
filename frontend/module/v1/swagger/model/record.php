<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="record"))
 */
class record
{

    /**
     * @SWG\Property(description="流水明细列表")
     * @var _record
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
