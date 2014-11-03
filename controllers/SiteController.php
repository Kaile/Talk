<?php

namespace app\controllers;

use app\models\MessageBuffer;
use app\models\Users;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
	const DEFAULT_CMD = 'store';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

	/**
	 * @return string
	 */
    public function actionIndex()
    {
		$query = new Query();
		$users = $query
			->select('id, login, registered')
			->from('users')
			->where(['<>', 'id', Yii::$app->user->identity->id])
			->all();
		
		return $this->render('index', ['users' => $users]);
    }

	/**
	 * @return string|\yii\web\Response
	 */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

	/**
	 * @return \yii\web\Response
	 */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	/**
	 * @return string|\yii\web\Response
	 */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

	/**
	 * @return string
	 */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionStore() 
	{
		if (! Yii::$app->request->post('text')) {
			return Yii::t('app', Yii::t('app', 'Text is not sended'));
		}

        $idTo = Yii::$app->request->post('id_to');

		if (! is_array($idTo)) {
			return Yii::t('app', 'Not entered user identifier');
		}

		foreach ($idTo as $userId) {
            $buffer = new MessageBuffer;
			$buffer->data = Yii::$app->request->post('text');
			$buffer->from = (int) Yii::$app->user->identity->id;
			$buffer->to = (int) $userId;
			$buffer->cmd = (Yii::$app->request->post('cmd')) ? Yii::$app->request->post('cmd') : self::DEFAULT_CMD;
			$buffer->save();
		}
		return true;
	}

	/**
	 * @return mixed
	 */
	public function actionLoad() 
	{
		/**
		 * @var $buff MessageBuffer
		 */
		$buff = (object) (new Query())
			->select('id, MIN(date) as date, data, from, cmd')
			->from('message_buffer')
			->where(['to' => Yii::$app->user->identity->id])
			->one();

		if ( ! empty($buff->data) ) {
            MessageBuffer::deleteAll(['id' => $buff->id]);
        }

		return Json::encode($buff);
	}

	/**
	 * @return string
	 */
	public function actionGetUsersList()
	{
		$result = Users::find()->addOrderBy('login ASC')->all();

		return Json::encode($result);
	}
}