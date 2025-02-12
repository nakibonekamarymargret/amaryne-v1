<?php

namespace app\controllers;

use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\SalonModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use app\models\User;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
            ],
        ];
    }

    public function actionIndex()
    {
        $salons = SalonModel::find()->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('index', ['salons' => $salons]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $this->layout = false;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Yii::$app->user->identity;
            if ($user->status !== 'active') {
                Yii::$app->session->setFlash('error', 'Please verify your email before logging in.');
                Yii::$app->user->logout();
                return $this->redirect(['site/login']);
            }

            // Redirect based on user role
            if ($user->role === 'salon owner') {
                return $this->redirect(['salon-owner/index']);
            } elseif ($user->role === 'admin') {
                return $this->redirect(['admin/dashboard']);
            }

            return $this->redirect(['site/index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $file = UploadedFile::getInstance($model, 'profileimage');
            if ($file) {
                $model->profileimage = 'uploads/' . uniqid('users_') . '.' . $file->extension;
                $file->saveAs($model->profileimage);
            }

            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->role = 'customer';
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->status = 'inactive'; 

            if ($model->save()) {
                // Send verification email
                $isSent=  Yii::$app->mailer->compose()
                ->setFrom('from@domain.com')
                ->setTo('to@domain.com')
                ->setSubject('Message subject')
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>HTML content</b>')
                ->send();

                if ($isSent) {
                    Yii::$app->session->setFlash('success', 'Registration successful. Please check your email to verify your account.');
                    return $this->redirect(['index']);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to send the verification email.');
                }
            } else {
                Yii::error('Registration failed: ' . json_encode($model->errors));
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionVerify($token)
    {
        $user = User::findOne(['auth_key' => $token, 'status' => 'inactive']);
        if ($user) {
            $user->auth_key = null; 
            $user->status = 'active'; 
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', 'Your account has been verified. You can now log in.');
                return $this->redirect(['site/login']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Invalid or expired verification token.');
        }

        return $this->redirect(['index']);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
