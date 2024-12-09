<?php
namespace app\controllers;

use app\models\RegisterForm;
use app\models\SalonModel;
use app\models\Services;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\UploadedFile;

class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['login', 'register'],
                'rules' => [
                    [
                        'actions' => ['register', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => false,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role !== 'admin';
                        },
                    ],
                    [
                        'actions' => ['logout', 'dashboard', 'total-salons', 'create', 'user-view', 'update', 'view-salon', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function actionDashboard()
    {
        $this->layout = 'adminLayout.php';
        $query = SalonModel::find();
        $salonsCount = $query->count();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $salonsCount,
        ]);

        $salons = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('dashboard', [
            'salonsCount' => $salonsCount,
            'salons' => $salons,
            'pagination' => $pagination,
        ]);
    }
    public function actionCreate()
    {
        $salon = new SalonModel();
        $this->layout = 'adminLayout.php';
        if (Yii::$app->request->isPost && $salon->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($salon, 'salon_image');
            if ($file) {
                $salon->salon_image = 'uploads/' . uniqid('salon_') . '.' . $file->extension;
                $file->saveAs($salon->salon_image);
            }

            if ($salon->save()) {
                Yii::$app->session->setFlash('success', 'Salon created successfully');
            } else {
                Yii::$app->session->setFlash('error', 'Error creating salon: ' . implode(', ', $salon->getFirstErrors()));
            }

            return $this->redirect(['admin/total-salons']);
        }

        Yii::$app->session->setFlash('error', 'Invalid request');
        return $this->redirect(['admin/total-salons']);
    }
    public function actionLogin()
    {
        $this->layout = false;

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Check if the logged-in user is not an admin, then log them out and redirect
            if (Yii::$app->user->identity->role !== 'admin') {
                Yii::$app->user->logout();
                return $this->redirect(['admin/access-denied']);
            }
            return $this->redirect(['admin/dashboard']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionAccessDenied()
    {
        $this->layout = 'main';
        return $this->render('access-denied');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['admin/dashboard']);
    }

    public function actionRegister()
    {
        $this->layout = false;

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['admin/dashboard']);
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'profileimage');
            if ($file) {
                $model->profileimage = 'uploads/' . uniqid('users_') . '.' . $file->extension;
                $file->saveAs($model->profileimage);
            }

            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->role = 'admin';
            $model->verification_token = Yii::$app->security->generateRandomString(); // Generate verification token
            $model->is_verified = 0; // Default to not verified

            if ($model->save()) {
                // Send verification email
                Yii::$app->mailer->compose(
                    ['html' => 'email-verification-html', 'text' => 'email-verification-text'],
                    ['user' => $model]
                )
                    ->setFrom([Yii::$app->params['senderEmail'] => 'Your App'])
                    ->setTo($model->email)
                    ->setSubject('Email Verification')
                    ->send();

                Yii::$app->session->setFlash('success', 'Registration successful. Please check your email to verify your account.');
                return $this->redirect(['login']);
            } else {
                Yii::error('Registration failed: ' . json_encode($model->errors));
            }
        }

        return $this->render('register-admin', [
            'model' => $model,
        ]);
    }
    public function actionVerifyEmail($token)
    {
        $user = RegisterForm::findOne(['verification_token' => $token, 'is_verified' => 0]);

        if (!$user) {
            throw new NotFoundHttpException('Invalid or expired token.');
        }

        $user->is_verified = 1; // Mark the user as verified
        $user->verification_token = null; // Clear the token
        if ($user->save()) {
            Yii::$app->session->setFlash('success', 'Your email has been successfully verified. You can now log in.');
            return $this->redirect(['login']);
        }

        Yii::$app->session->setFlash('error', 'Failed to verify your email. Please try again.');
        return $this->redirect(['register']);
    }

    public function actionUpdate($id)
    {
        $this->layout = 'adminLayout';
        $salon = $this->findModel($id);

        if ($this->request->isPost && $salon->load($this->request->post())) {
            $file = UploadedFile::getInstance($salon, 'salon_image');
            if ($file) {
                $salon->salon_image = 'uploads/' . uniqid('salons/') . '.' . $file->extension;
                $file->saveAs($salon->salon_image);
            }
            if ($salon->save()) {
                return $this->redirect(['total-salons', 'id' => $salon->id]);
            }
        }

        return $this->render('update', [
            'salon' => $salon,
        ]);
    }

    public function actionUserView()
    {
        $model = RegisterForm::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $model->count()
        ]);
        $users = $model->offset($pagination->offset)->limit($pagination->limit)->all();
        return $this->render('register-view', ['users' => $users, 'pagination' => $pagination]);
    }

    public function actionTotalSalons()
    {
        $salon = new SalonModel();
        $this->layout = 'adminLayout';
        $salonCount = SalonModel::find()->count();
        $service = new Services();

        $pagination = new Pagination([
            'totalCount' => $salonCount,
            'defaultPageSize' => 10,
        ]);

        $salons = SalonModel::find()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $salonModel = new SalonModel();

        return $this->render('total-salons', [
            'salon' => $salon,
            'salons' => $salons,
            'pagination' => $pagination,
            'services' => $service,
            'salonModel' => $salonModel,
        ]);
    }

    public function actionViewSalon($id)
    {
        $this->layout = 'adminLayout';
        $salon = SalonModel::findOne($id);
        $serviceCount = $salon->getServices()->count();
        if ($salon) {
            return $this->asJson([
                'name' => $salon->name,
                'details' => $this->renderPartial('_salon-view', ['salon' => $salon]),
                'serviceCount' => $serviceCount,
            ]);
        }

        return $this->asJson([
            'error' => 'Error loading salon details',
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['dashboard']);
    }

    protected function findModel($id)
    {
        if (($model = SalonModel::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
