<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\filters\RateLimitInterface;

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

    public $rank;
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
            [['coca_id', 'points', 'exp', 'nog', 'access_expired_at', 'refresh_expired_at', 'status'], 'integer'],
            [['created_at', 'updated_at', 'rank', 'level'], 'safe'],
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
            'nog' => 'Nog',
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
        $level = Level::getLevelByScore($this->exp);
        return empty($level)? '菜鸟': $level;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::find()->where(['access_token'=> $token])->andWhere(['>', 'access_expired_at', time()])->one();
    }

    public static function findIdentityByRefreshToken($token, $type = null)
    {
        return static::find()->where(['refresh_token'=> $token])->andWhere(['>', 'refresh_expired_at', time()])->one();
    }

    public static function findById($id)
    {
        $user = static::find()->where(['id'=> $id])->one();
        if (is_null($user)) {
            throw new \yii\web\NotFoundHttpException();
        }
        return $user;
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

    /**
     * [getChapterDone 已完成的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-24
     * @return [type] [description]
     */
    public function getChapterDone()
    {
        return ChapterChild::totalDone($this->id);
    }

    /**
     * [getChapterDone 总的关卡数]
     * #Author ckhero
     * #DateTime 2018-02-24
     * @return [type] [description]
     */
    public function getChapterTotal()
    {
        return ChapterChild::total();
    }

    /**
     * [getCurrentMapId 当前地图id]
     * #Author ckhero
     * #DateTime 2018-02-24
     * @return [type] [description]
     */
    // public function getCurrentMapId()
    // {
    //     $mapHasChapters = Map::eachMapChapters();
    //     $done = $this->chapterDone;
    //     $mapNum = count($mapHasChapters);
    //     $i = 0;
    //     foreach ($mapHasChapters as $key => $chpatersNum) {
    //         $i++;
    //         if ($i == $mapNum) return $key;
    //         $done -= $chpatersNum;
    //         if ($done < 0) {
    //             return $key;
    //         }
    //     } 
    // }
    public static function addExp($exp = 0)
    {
        $model = static::findById(Yii::$app->user->id);
        return $model->updateCounters(['exp' => $exp]);
        //return $model->save();
    }

    public static function addNog($nog = 0)
    {
        $model = static::findById(Yii::$app->user->id);
        return $model->updateCounters(['nog' => $nog]);
        //return $model->save();
    }
    /**
     * [getDayMissionStatus 日常任务状态，1为完成，0为未完成]
     * #Author ckhero
     * #DateTime 2018-02-06
     * @return [type] [description]
     */
    public function getDayMissionStatus()
    {
        return UserChapterRecord::isDayMissionDone(Yii::$app->user->id);
    }

    public function getDayMissionNum()
    {
        return UserChapterRecord::isDayMissionDone($this->id)? 0: 1;
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['created_at'], $fields['updated_at'], $fields['access_expired_at'], $fields['refresh_expired_at']);
        if (Yii::$app->controller->id != 'coca' || Yii::$app->controller->action->id != 'login') {
            unset($fields['access_token'], $fields['refresh_token']);
        }
        return array_merge($fields, ['rank', 'level', 'chapterDone', 'chapterTotal', 'bossTime', 'dayMissionNum']);   
    }

    /**
     * [addDoubleTime 增加双倍时间]
     * #Author ckhero
     * #DateTime 2018-02-07
     */
    public static function addDoubleTime($seconds = 3600)
    {
        $model = static::findById(Yii::$app->user->id);
        if (strtotime($model->double_end) < time()) {
            $model->double_end = date('Y-m-d H:i:s', time() + $seconds);
        } else {
            $model->double_end = strtotime($model->double_end) < time()? date('Y-m-d H:i:s', time() + $seconds): date('Y-m-d H:i:s', strtotime($model->double_end) + $seconds);
        }
        return $model->save();
    }

    public static function getCocaIdById()
    {
        $model = static::findById(Yii::$app->user->id);
        return $model->coca_id;
    }

    /**
     * [findOrCreateByCache 找到可乐用户在本系统中的用户信息，没找到则根据缓存中的信息生成用户]
     * #Author ckhero
     * #DateTime 2018-02-23
     * @return [type] [description]
     */
    public static function findOrCreateByCache($cocaId = 0)
    {
        if ($cocaId == 0) {
            throw new \Exception("用户信息为空", 1);
        }
        $model = static::findOne(['coca_id'=> $cocaId]);
        if (is_null($model)) {
            $userInfo = Yii::$app->cache->get('COCA_'.$cocaId);
            if (empty($userInfo)) {
                throw new \Exception("用户信息为空", 1);
            }
            $model = new static();
            $model->coca_id = $userInfo['coca_id'];
            $model->nick_name = $userInfo['nick_name'];
            $model->head_img = $userInfo['head_img'];
            $model->nick_name = $userInfo['nick_name'];
            $model->bottler_group = $userInfo['bottler_group'];
            $model->bottler_name = $userInfo['bottler_name'];
            $model->save();
        }
        return $model;
    }

    /**
     * [getBossTime 得到下次世界boss的时间]
     * #Author ckhero
     * #DateTime 2018-02-26
     * @return [type] [description]
     */
    public function getBossTime()
    {
        $boss = Boss::findCurrOrNextBoss();
        return is_null($boss)? '': $boss->start;
    }
}
