<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="_record"))
 */
class _record
{

    /**
     * @SWG\Property(description="获取途径名称", example="世界boss")
     * @var string
     */
    private $activity_name;



    /**
     * @SWG\Property(description="积分值", example="1")
     * @var int
     */
    private $point;

     /**
     * @SWG\Property(description="经验值", example="1")
     * @var int
     */
    private $exp;

}
