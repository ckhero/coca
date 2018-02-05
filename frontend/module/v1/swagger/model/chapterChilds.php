<?php

/**
 * @SWG\Definition(required={}, type="object", @SWG\Xml(name="chapterChilds"))
 */
class chapterChilds
{

    /**
     * @SWG\Property(description="小关卡id")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(description="小关卡所属关卡id",)
     * @var int
     */
    private $chapter_id;

    /**
     * @SWG\Property(description="小关卡名字")
     * @var string
     */
    
    private $name;
     /**
     * @SWG\Property(description="小关卡描述")
     * @var string
     */
    private $desc;


    /**
     * @SWG\Property(description="小关卡排序", example="1")
     * @var int
     */
    private $sort;

    /**
     * @SWG\Property(description="关卡是否完成;undo未完成，done已完成", example="undo")
     * @var string
     */
    private $status;

    /**
     * @SWG\Property(description="小关卡问题列表（添加更新只要传id就行）")
     * @var Questions[]
     */
    private $questions;

}
