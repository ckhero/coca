<?php

/**
 * @SWG\Definition(type="object", @SWG\Xml(name="battleResult"))
 */
class battleResult
{

    /**
     * @SWG\Property(description="答题情况，状态码的值  0对战信息不存在，1为对战结束出结果了，2为你已完成对战，对手还未完成", enum={"0","1","2"}, example="0")
     * @var int
     */
    private $code;

    /**
     * pet status in the store
     * @SWG\Property(description="状态码描述", example="全部答错")
     * @var string
     */
    private $message;

    /**
     * pet status in the store
     * @SWG\Property(description="答题总数", example="100")
     * @var interger
     */
    private $total;

    /**
     * pet status in the store
     * @SWG\Property(description="答对的题目数", example="99")
     * @var interger
     */
    private $rightOptionNum;


    /**
     * pet status in the store
     * @SWG\Property(description="0输，1 赢，2平局", enum={"0","1","2"},example="0")
     * @var interger
     */
    private $status_win;

}
