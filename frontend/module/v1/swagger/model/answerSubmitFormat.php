<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="answerSubmitFormat"))
 */
class answerSubmitFormat
{

    /**
     * @SWG\Property(description="题目id")
     * @var int
     */
    private $id;

    /**
     * pet status in the store
     * @SWG\Property(description="用户选项", example="A")
     * @var string
     */
    private $option;

}
