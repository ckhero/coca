<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="chapterAdd"))
 */
class chapterAdd
{

    /**
     * @SWG\Property(description="关卡id")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="关卡所属地图id",)
     * @var int
     */
    private $map_id;

    /**
     * @SWG\Property(description="关卡名字")
     * @var string
     */
    
    private $name;
     /**
     * @SWG\Property(description="关卡描述")
     * @var string
     */
    private $desc;

    /**
     * @SWG\Property(description="关卡背景图片", example="uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg")
     * @var string
     */
    private $bg_url;


    /**
     * @SWG\Property(description="关卡排序", example="1")
     * @var int
     */
    private $sort;
}
