<?php

/**
 * @SWG\Definition(required={"name", "sort"}, type="object", @SWG\Xml(name="maps"))
 */
class maps
{

    /**
     * @SWG\Property(description="地图id")
     * @var int
     */
    private $id;
    /**
     * @SWG\Property(description="地图名字", enum={"春","夏","秋","冬"})
     * @var string
     */
    
    private $name;
     /**
     * @SWG\Property(description="地图描述")
     * @var string
     */
    private $desc;

    /**
     * @SWG\Property(description="地图背景图片", example="uploads/20180202/46b0ba04-ca6c-12e4-b90d-803aaeef5e39.jpg")
     * @var string
     */
    private $bg_url;



    /**
     * @SWG\Property(description="地图排序", example="1")
     * @var int
     */
    private $sort;
}
