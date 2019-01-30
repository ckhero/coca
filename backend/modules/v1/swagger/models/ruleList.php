<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="ruleList"))
 */
class ruleList
{

    /**
     * @SWG\Property(description="帮助 列表")
     * @var rule[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
