<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="_boss"))
 */
class _boss
{

    /**
     * @SWG\Property(description="血量")
     * @var int
     */
    
    private $hp;

    /**
     * @SWG\Property(description="减少的血量（剩余血量需要计算）")
     * @var int
     */
    
    private $reduced;
    /**
     * @SWG\Property(description="开始时间")
     * @var string
     */
    
    private $start;

    /**
     * @SWG\Property(description="结束时间")
     * @var string
     */
    
    private $end;

}
