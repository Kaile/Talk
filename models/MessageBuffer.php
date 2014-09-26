<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_buffer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $data
 * @property string $date
 */
class MessageBuffer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message_buffer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['data'], 'string', 'max' => 255]
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
            'data' => Yii::t('app', 'Data'),
            'date' => Yii::t('app', 'Date'),
        ];
    }
}
