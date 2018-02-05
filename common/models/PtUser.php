<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "co_pt_user".
 *
 * @property int $id
 * @property int $coca_id 可口可乐的用户id
 * @property string $nick_name
 * @property string $head_img
 * @property int $points 积分，跟渴了挂钩
 * @property int $exp 经验值
 * @property string $access_token
 * @property string $refresh_token
 * @property int $access_expired_at access_token过期时间
 * @property int $refresh_expired_at refresh_token过期时间
 * @property int $status 用户状态
 * @property string $created_at
 * @property string $updated_at
 */
class PtUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    const ACCESS_EXPIRED_TIME = 3600;
    const REFRESH_EXPIRED_TIME = 3600 * 24;
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'co_pt_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['coca_id', 'points', 'exp', 'access_expired_at', 'refresh_expired_at', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nick_name'], 'string', 'max' => 128],
            [['head_img'], 'string', 'max' => 255],
            [['access_token', 'refresh_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coca_id' => 'Coca ID',
            'nick_name' => 'Nick Name',
            'head_img' => 'Head Img',
            'points' => 'Points',
            'exp' => 'Exp',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'access_expired_at' => 'Access Expired At',
            'refresh_expired_at' => 'Refresh Expired At',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function loginOrCreate($params = []) 
    {
        $coca_id = intval($params['KOUserId']);
        $user = static::findOne(['coca_id'=> $coca_id]);
        if ($user == null) {
            //新建一个用户
            $user = new static();

            $user->coca_id = $coca_id;
            $user->nick_name = $params['NickName']?? '';
            $user->head_img = $params['HeadImgUrl']?? '';
            $user->generateAccessToken();
            $user->generateReFreshToekn();
        } else {
            $user->generateAccessToken();
            $user->generateReFreshToekn();
        }
        $user->save();
        return $user;
    }

    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();
        $this->access_expired_at = time() + self::ACCESS_EXPIRED_TIME;
        return $this->access_token;
    }


    public function generateReFreshToekn(){
        $this->refresh_token = Yii::$app->security->generateRandomString();
        $this->refresh_expired_at = time() + self::REFRESH_EXPIRED_TIME;
        return $this->refresh_token;
    }

    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            // $this->right_option = chr($this->right_option + 64);
            if ($insert) {

                $this->created_at = date('Y-m-d H:i:s');
                $this->updated_at = date('Y-m-d H:i:s');
                
            } else {

                $this->updated_at = date('Y-m-d H:i:s');
            }

            return true;
        }

        return false;
    }

    /**
     * [getLevel 用户等级]
     * @Author   ckhero
     * @DateTime 2018-02-04
     * @return   [type]     [description]
     */
    public function getLevel()
    {
        return Level::getLevelByScore($this->exp);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['access_token'=> $token])->andWhere(['>', 'access_expired_at', time()])->one();
    }

    public static function findIdentityByRefreshToken($token, $type = null)
    {
        return static::find()->where(['refresh_token'=> $token])->andWhere(['>', 'refresh_expired_at', time()])->one();
    }

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getChapterDone()
    {
        return Level::getLevelByScore($this->exp);
    }
}
