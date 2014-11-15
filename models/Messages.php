<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $message
 * @property string $date
 * @property integer $to
 * @property integer $from
 *
 * @property Users $from0
 * @property Users $to0
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'string'],
            [['date'], 'safe'],
            [['to', 'from'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'message' => Yii::t('app', 'Message'),
            'date' => Yii::t('app', 'Date'),
            'to' => Yii::t('app', 'To'),
            'from' => Yii::t('app', 'From'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFrom0()
    {
        return $this->hasOne(Users::className(), ['id' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTo0()
    {
        return $this->hasOne(Users::className(), ['id' => 'to']);
    }

    public function beforeSave($insert = null)
    {
        $this->date = date('Y/m/d h:i:s');

        return true;
    }
}
