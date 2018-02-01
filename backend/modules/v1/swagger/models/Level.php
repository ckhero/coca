<?php

/**
 * @SWG\Definition(required={"score", "name"}, type="object", @SWG\Xml(name="Level"))
 */
class Level
{

    /**
     * @SWG\Property(description="等级id")
     * @var int
     */
    private $id;
     /**
     * @SWG\Property(description="数值")
     * @var int
     */
    private $score;

    /**
     * pet status in the store
     * @SWG\Property( description="等级名字")
     * @var string
     */
    private $name;
}
