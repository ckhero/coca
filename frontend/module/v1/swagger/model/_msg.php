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
     * @SWG\Property(description="消息内容")
     * @var string
     */
    private $detail;

}
