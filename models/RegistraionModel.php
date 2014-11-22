<?php
/**
 * Created by PhpStorm.
 * User: Mihail Kornilov
 * Date: 16.11.2014
 * Time: 15:48
 */

namespace app\models;

use yii\base\Model;
use Yii;

class RegistraionModel extends Model
{
	public $login;
	public $password;
	public $password2;
	public $email;

	const EMAIL_PATTERN = '/^.+@.+\.\w+$/';

	public function rules()
	{
		return [
			[['login', 'password', 'password2', 'email'], 'required'],
			['login', 'validateLogin'],
			[['password', 'password2'], 'validatePassword'],
			['email', 'validateEmail'],
		];
	}

	public function validatePassword($attribute)
	{
		if ($this->password !== $this->password2) {
			$this->addError($attribute, Yii::t('app', 'Passwords not equal'));
			return false;
		}
		return true;
	}

	public function validateEmail($attribute)
	{
		if ( !preg_match(self::EMAIL_PATTERN, $this->email) ) {
			$this->addError($attribute, Yii::t('app', 'Bad email format'));
			return false;
		}
		return true;
	}

	public function attributeLabels()
	{
		return [
			'login' 	=> Yii::t('app', 'Username'),
			'password' 	=> Yii::t('app', 'Password'),
			'password2' => Yii::t('app', 'Repeat password'),
			'email' 	=> Yii::t('app', 'E-mail'),
		];
	}

	public function validateLogin($attribute)
	{
		$loginExists = Users::find()->where(['login' => $this->login])->one();

		if ($loginExists) {
			$this->addError($attribute, Yii::t('app', 'User with that login "{login}" are registered', ['login' => $this->login]));
			return false;
		}
		return true;
	}
}
