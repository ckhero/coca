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

}
