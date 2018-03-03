<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="_msg"))
 */
class _msg
{

    /**
     * @SWG\Property(description="battle_id 对战的id,用于用户应战时候用到")
     * @var int
     */
    private $battle_id;

    /**
     * @SWG\Property(description="消息类型    1; //关卡
2; //世界boss
3;//每日任务
4;//小游戏
5;//对战")
     * @var int
     */
    private $type;

    /**
     * @SWG\Property(description="消息内容")
     * @var string
     */
    private $detail;

    /**
     * @SWG\Property(description="是需要应战，0为普通消息无需迎战，1为需要应战")
     * @var string
     */
    private $is_battle;

    /**
     * @SWG\Property(description="1为对战结束，已完成对战，2为对战未完成，已超时，3为对战未完成，但用户已经完成答题，4为对战未完成，用户未答题")
     * @var string
     */
    private $battleStatus;

}
