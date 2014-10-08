<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $surname
 * @property string $lastname
 * @property string $born_date
 * @property string $phone_number
 *
 * @property Users $user
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['born_date'], 'safe'],
            [['name', 'surname', 'lastname', 'phone_number'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
            'surname' => Yii::t('app', 'Surname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'born_date' => Yii::t('app', 'Born Date'),
            'phone_number' => Yii::t('app', 'Phone Number'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
