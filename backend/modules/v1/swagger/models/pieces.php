<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="pieces"))
 */
class pieces
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
     * @SWG\Property(description="碎片所属道具的id，道具的pid为0", example=0)
     * @var int
     */
    private $pid;

    /**
     * @SWG\Property(description="碎片编号", example=0)
     * @var int
     */
    private $sort;
}
