<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * @inheritdoc
     */
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->redirect(['site/login']);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['user/view']);
        }

        $model = new LoginForm();
        
        $session = Yii::$app->session;
        if(!$session->has('attempt')) {
            $session->set('attempt', 0);
        }
        if($session->has('LAST_ACTIVITY')) {
            if ($session['LAST_ACTIVITY'] < time() - (60*5)) {
                unset($session['attempt']);
            }
        }
        if ($session['attempt'] < 3 && $model->load(Yii::$app->request->post()) && $model->login()) {
            unset($session['attempt']);
            return $this->redirect(['user/view']);
        } else {
            if($session['attempt'] < 3){
                $attempts = $session['attempt'] + 1;
                $session->set('attempt', $attempts);
                $session->set('LAST_ACTIVITY', time());
            } else{
                $time = $session['LAST_ACTIVITY'];
                Yii::$app->session->setFlash('fail', 'Максимальное количество попыток - 3, попробуйте через некоторое время: ' . (($time + 60*5) - time()) . ' секунд');
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
