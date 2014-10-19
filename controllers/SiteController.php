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
			->select('id, login')
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
		if (! Yii::$app->request->post('id_to')) {
			return Yii::t('app', 'Not entered user identifier');
		}

		$buffer = new MessageBuffer;

		$buffer->data = Yii::$app->request->post('text');
		$buffer->from = (int) Yii::$app->user->identity->id;
		$buffer->to   = (int) Yii::$app->request->post('id_to');
		$buffer->cmd  = (Yii::$app->request->post('cmd')) ? Yii::$app->request->post('cmd') : self::DEFAULT_CMD;

		return $buffer->save();
	}

	/**
	 * @return mixed
	 */
	public function actionLoad() 
	{
		$row = (new Query())
			->select('id, MIN(date), data, from, cmd')
			->from('message_buffer')
			->where(['to' => Yii::$app->user->identity->id])
			->one();

        $res = $row['data'];

		if ( ! empty($res) ) {
            MessageBuffer::deleteAll(['id' => $row['id']]);
        }

		return $res;
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
