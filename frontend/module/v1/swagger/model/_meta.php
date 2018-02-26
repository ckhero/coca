<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="_meta"))
 */
class _meta
{

    /**
     * @SWG\Property(description="当前地图id")
     * @var int
     */
    
    private $curr;

    /**
     * @SWG\Property(description="上一张地图id")
     * @var int
     */
    
    private $prev;
    /**
     * @SWG\Property(description="下一张地图id")
     * @var int
     */
    
    private $next;

}
