<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="responsePiece"))
 */
class responsePiece
{

    /**
     * @SWG\Property(description="0 表示失败，1表示成功", enum={"0","1"}, example="0")
     * @var int
     */
    private $code;

    /**
     * pet status in the store
     * @SWG\Property(description="状态码描述", example="操作失败")
     * @var string
     */
    private $message;

    /**
     * pet status in the store
     * @SWG\Property(description="成功情况下返回道具信息", example="")
     * @var props
     */
    private $data;

}
