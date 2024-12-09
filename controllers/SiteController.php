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
use app\models\ContactForm;
use app\models\User;

use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
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
        // $this->layout=false;
        $salons = SalonModel::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', ['salons' => $salons]);
    }
    /**
     * Login action.
     *
     * @return Response|string
     */
    // controllers/LoginController.php

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
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
            // Handle profile image upload
            $file = UploadedFile::getInstance($model, 'profileimage');
            if ($file) {
                $model->profileimage = 'uploads/' . uniqid('users/') . '.' . $file->extension;
                $file->saveAs($model->profileimage);
            }

            // Hash the password and set other user attributes
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->role = 'customer';
            $model->auth_key = Yii::$app->security->generateRandomString();

            if ($model->save()) {
                // $confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirm', 'token' => $model->auth_key]);

                // Yii::$app->mailer->compose(['html' => 'emailConfirmation', 'text' => 'verification-text'], [
                //     'confirmLink' => $confirmLink,
                //     'user' => $model,
                // ])
                //     ->setFrom(Yii::$app->params['senderEmail'])
                //     ->setTo($model->email)
                //     ->setSubject('Go to your email to confirm your account Confirmation')
                //     ->send();

                // Yii::$app->session->setFlash('success', 'Registration successful. Check your email for confirmation.');
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['index']);
            } else {
                Yii::error('Registration failed: ' . json_encode($model->errors));
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionConfirm($token)
    {
        $user = User::findOne(['auth_key' => $token]);

        if ($user) {
            $user->is_verified = 1;
            $user->auth_key = null;
            $user->save(false);
            Yii::$app->session->setFlash('success', 'Your account has been confirmed. You can now login.');
            return $this->redirect(['login']);
        }

        Yii::$app->session->setFlash('error', 'Invalid confirmation token.');
        return $this->redirect(['index']);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionEmail()
    {
        Yii::$app->mailer->compose()
            ->setFrom('somebody@domain.com')
            ->setTo('nakibonekamarymargret@gmail.com')
            ->setSubject('Email sent from Yii2-Swiftmailer')
            ->send();
    }
    /**
     * Displays contact page.
     *
     * @return Response|string
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
