<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="game"))
 */
class game
{

    /**
     * @SWG\Property(description="第几关")
     * @var int
     */
    private $chapter_id;

     /**
     * @SWG\Property(description="积分")
     * @var int
     */
    private $point;


}
