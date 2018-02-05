<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="chapterAnswer"))
 */
class chapterAnswer
{

    /**
     * @SWG\Property(description="子关卡id，也就是题目所属关卡id")
     * @var int
     */
    private $chapter_child_id;

    /**
     * pet status in the store
     * @SWG\Property(description="用户选项")
     * @var answerSubmitFormat[]
     */
    private $options;

}
