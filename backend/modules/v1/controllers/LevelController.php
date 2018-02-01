<?php

namespace backend\modules\v1\controllers;

class LevelController extends \common\base\BaseController
{
	public $modelClass=  'common\models\Level';

	/**
     * @SWG\Get(path="/v1/levels",
     *   tags={"等级管理"},
     *   summary="返回等级列表",
     *   description="返回等级列表",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="第几页",
     *         in="path",
     *         name="page",
     *         required=true,
     *         type="integer",
     *         required=false,
     *     ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema( type="array", @SWG\Items(ref="#/definitions/LevelList")), description="获取成功"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    /**
     * @SWG\Delete(path="/v1/levels/{id}",
     *   tags={"等级管理"},
     *   summary="删除等级",
     *   description="删除等级",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *  @SWG\Parameter(
     *         description="等级id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         type="integer"
     *     ),
     *  @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=204,description="删除成功"),
     *   @SWG\Response(response=404,description="等级不存在"),
     *   @SWG\Response(response=401,description="身份认证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Post(path="/v1/levels",
     *   tags={"等级管理"},
     *   summary="添加等级",
     *   description="添加等级",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="等级和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/Level"
     *     )
     *   ),
     *    @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=201, @SWG\Schema(ref="#/definitions/Level"), description="添加成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Put(path="/v1/levels/{id}",
     *   tags={"等级管理"},
     *   summary="更新等级",
     *   description="更新等级",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="等级id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="待更新等级和选项json串",
     *     required=true,
     *     @SWG\Schema(
     *       ref="#/definitions/Level"
     *     )
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/Level"), description="更新成功"),
     *   @SWG\Response(response=422, description="数据验证失败"),
     *   @SWG\Response(response=404,description="等级不存在"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */
    
    /**
     * @SWG\Get(path="/v1/levels/{id}",
     *   tags={"等级管理"},
     *   summary="查看等级",
     *   description="查看等级",
     *   operationId="getInventory",
     *   produces={"application/json"},
     *   @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     description="等级id",
     *     required=true,
     *     type="integer"
     *   ),
     *   @SWG\Parameter(
     *         description="身份令牌",
     *         in="query",
     *         name="access-token",
     *         required=true,
     *         type="string",
     *     ),
     *   @SWG\Response(response=200, @SWG\Schema(ref="#/definitions/Level"), description="更新成功"),
     *   @SWG\Response(response=404,description="等级不存在"),
     *   @SWG\Response(response=401,description="身份验证失败"),
     *   security={
     *     {"Authorization": {}},
     *   }
     * )
     */

}
