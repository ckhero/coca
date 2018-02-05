<?php

/**
 * @SWG\Definition(required={}, type="object", @SWG\Xml(name="chapters"))
 */
class chapters
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

    /**
     * @SWG\Property(description="关卡是否完成;undo未完成，done已完成， doing完成部分", example="undo")
     * @var string
     */
    private $status;

    /**
     * @SWG\Property(description="关卡引导，里面放着关卡引导的图片视频等(多张图片或视频逗号隔开)")
     * @var string
     */
    private $guide;

    /**
     * @SWG\Property(description="子关卡列表")
     * @var chapterChilds[]
     */
    private $chapterChilds;
}
