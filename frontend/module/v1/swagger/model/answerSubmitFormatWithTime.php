<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="answerSubmitFormatWithTime"))
 */
class answerSubmitFormatWithTime
{


    /**
     * pet status in the store
     * @SWG\Property(description="选项")
     * @var answerSubmitFormat[]
     */
    private $options;

    /**
     * pet status in the store
     * @SWG\Property(description="答题花费的时间，单位秒", example="100")
     * @var interger
     */
    private $cost_time;


}
