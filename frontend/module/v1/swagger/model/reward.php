<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="reward"))
 */
class reward
{

    /**
     * @SWG\Property(description="奖励的碎片列表")
     * @var piece[]
     */
    private $pieces;

    /**
     * @SWG\Property(description="奖励的道具列表")
     * @var piece[]
     */
    private $props;
    /**
     * @SWG\Property(description="奖励的经验")
     * @var int
     */
    private $exp;

    /**
     * @SWG\Property(description="奖励的积分")
     * @var int
     */
    private $points;

    /**
     * @SWG\Property(description="奖励的小游戏次数")
     * @var int
     */
    private $nog;


}
