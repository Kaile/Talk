<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message_buffer".
 *
 * @property integer $id
 * @property string $data
 * @property string $date
 * @property string $from
 * @property string $to
 * @property string $cmd
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
            [['date'], 'safe'],
            [['data'], 'string', 'max' => 255],
			[['from'], 'integer'],
			[['to'], 'integer'],
			[['cmd'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'data' => Yii::t('app', 'Data'),
            'date' => Yii::t('app', 'Date'),
			'from' => Yii::t('app', 'Sended from'),
			'to' => Yii::t('app', 'Sended to'),
			'cmd' => Yii::t('app', 'Command'),
        ];
    }

	public function beforeSave()
	{
		$this->date = date('Y/m/d h:i:s');
		return true;
	}
}
