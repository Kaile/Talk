<?php

namespace app\models;

use Yii;
use yii\base\Security;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 * @property string $registered
 * @property string $auth_key
 * @property string $access_token
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['registered'], 'safe'],
            [['login', 'password', 'auth_key', 'access_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'login' => Yii::t('app', 'Login'),
            'password' => Yii::t('app', 'Password'),
            'registered' => Yii::t('app', 'Registered'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'access_token' => Yii::t('app', 'Access Token'),
        ];
    }
	
	public static function findIdentity($id)
	{
		return new static(self::findOne(['id' => $id]));
	}

	public static function findIdentityByAccessToken($token, $type = NULL)
	{
		return new static(self::findOne(['access_token' => $token]));
	}

    public static function findByUserName($username)
    {
        return new static(self::findOne(['login' => $username]));
    }

	public function getAuthKey()
	{
		return $this->auth_key;
	}

	public function getId()
	{
		return $this->id;
	}

	public function validateAuthKey($authKey)
	{
		return $this->auth_key === $authKey;
	}

	public function validatePassword($password)
	{
		if ($this->password === hash('sha256', $password)) {
            return true;
        }
        return false;
	}

    public function beforeSave()
    {
        $this->password = hash('sha256', $this->password);
		$this->registered = date('Y/m/d h:i:s');
		$security = new Security();
		$this->auth_key = $security->generateRandomString();
		$this->access_token = $security->generateRandomString();

		return true;
    }
}