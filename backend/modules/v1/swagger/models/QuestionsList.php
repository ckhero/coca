<?php

/**
 * @SWG\Definition(required={"desc", "right_option"}, type="object", @SWG\Xml(name="QuestionsList"))
 */
class QuestionsList
{

    /**
     * @SWG\Property(description="题目列表")
     * @var questions[]
     */
    private $items;

    /**
     * pet status in the store
     * @SWG\Property(description="相关信息")
     * @var ListInfo
     */
    private $_meta;

}
