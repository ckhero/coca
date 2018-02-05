<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="chaptersList"))
 */
class chaptersList
{

    /**
     * @SWG\Property(description="关卡列表")
     * @var chapters[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
