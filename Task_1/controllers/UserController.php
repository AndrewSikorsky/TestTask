<?php

namespace app\controllers;
use Yii;
use yii\filters\AccessControl;

class UserController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actionView()
    {
        $user = Yii::$app->user->identity;
        
        return $this->render('view', [
            'user' => $user,
        ]);
    }
}
