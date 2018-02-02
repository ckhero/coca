<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="props"))
 */
class props
{

    /**
     * @SWG\Property(description="[道具/道具碎片]id")
     * @var int
     */
    private $id;
    /**
     * @SWG\Property(description="[道具/道具碎片]名字")
     * @var string
     */
    
    private $name;
     /**
     * @SWG\Property(description="[道具/道具碎片]描述")
     * @var string
     */
    private $desc;

    /**
     * @SWG\Property(description="[道具/道具碎片]图片")
     * @var string
     */
    private $img_url;



    /**
     * @SWG\Property(description="道具的碎片列表")
     * @var pieces[]
     */
    private $pieces;
}
