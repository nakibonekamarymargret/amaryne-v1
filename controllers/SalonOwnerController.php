<?php
namespace app\controllers;

use app\models\ProductsModel;
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

class SalonOwnerController extends Controller
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
                        'roles' => ['salon owner', 'admin'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->role !== 'salon owner';
                        },
                    ],
                    [
                        'actions' => ['logout', 'dashboard', 'total-salons', 'create', 'user-view', 'edit', 'view-salon', 'delete'],
                        'allow' => true,
                        'roles' => ['salon owner'],
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
    public function actionIndex()
    {
        $this->layout = 'ownerLayout.php';

        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();
        $salonName = $salon ? $salon->name : 'amaryne Salonist';

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
            'model' => Yii::$app->user->identity,
            'salon' => $salon,
            'salonName' => $salonName,
            'salonsCount' => $salonsCount,
            'salons' => $salons,
            'pagination' => $pagination,
        ]);
    }
    public function actionCreate()
    {
        $salon = new SalonModel();
        $this->layout = 'ownerLayout.php';
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

            return $this->redirect(['salon-owner/total-salons']);
        }

        Yii::$app->session->setFlash('error', 'Invalid request');
        return $this->redirect(['salon-owner/total-salons']);
    }
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $this->layout = false;
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->identity->role === 'salon owner' || Yii::$app->user->identity->role === ' admin') {
                return $this->redirect(['salon-owner/index']);
            } else {
                Yii::$app->user->logout();
                return $this->redirect(['salon-owner/access-denied']);
            }
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
        return $this->redirect(['salon-owner/index']);
    }
    public function actionRegister()
    {
        $this->layout = false;
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['salon-owner/dashboard']);
        }
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'profileimage');
            if ($file) {
                $model->profileimage = 'uploads/' . uniqid('users/') . '.' . $file->extension;
                $file->saveAs($model->profileimage);
            }

            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->role = 'salon owner';

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['welcome']);
            } else {
                Yii::error('Registration failed: ' . json_encode($model->errors));
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
    public function actionWelcome()
    {
        $model = Yii::$app->user->identity;
        return $this->render(
            'welcome',
            ['model' => $model]
        );

    }
    public function actionUpdate($id)
    {
        $model = RegisterForm::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("User not found");
        }
        $request = Yii::$app->request;
        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "User has been successfully updated");

            return $this->redirect(['register-view']);

        }

        return $this->render('update', ['model' => $model]);
    }
    public function actionEdit($id)
    {
        $this->layout = 'adminLayout';
        $salon = SalonModel::findOne($id);

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

        return $this->render('edit', [
            'salon' => $salon,
        ]);
    }
    public function actionCreateSalon()
    {
        $model = new SalonModel();
        $model->owner_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'salon_image');

            if ($file) {
                $model->salon_image = 'uploads/' . uniqid() . '.' . $file->extension;
                $file->saveAs(Yii::getAlias('@webroot/') . $model->salon_image);
            }

            // Save the salon to the database
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Salon created successfully!');
                return $this->redirect(['salon-owner/services']);
            }
        }
        return $this->render('create-salon', [
            'model' => $model,
        ]);
    }
    public function actionDeleteSalon($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['dashboard']);
    }
    public function actionServices()
    {
        $this->layout = 'ownerLayout';

        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();

        if ($salon === null) {
            Yii::$app->session->setFlash('error', 'Please create a salon first.');
            return $this->redirect(['salon-owner/create-salon']);
        }

        $model = new Services();
        $services = Services::find()->where(['salon_id' => $salon->id, 'status' => 'active'])->all();

        return $this->render('services', [
            'salon' => $salon,
            'model' => $model,
            'services' => $services,
            'salon_id' => $salon->id,
        ]);
    }

    public function actionCreateService()
    {
        $model = new Services();
        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();

        if ($salon !== null) {
            $model->salon_id = $salon->id;
        } else {
            Yii::$app->session->setFlash('error', 'Salon not found. Please create a salon first.');
            return $this->redirect(['salon-owner/create-salon']);
        }

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'service_image');
            if ($file) {
                $model->service_image = 'uploads/' . uniqid('service_') . '.' . $file->extension;
                $file->saveAs($model->service_image);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Service created successfully.');
                return $this->redirect(['salon-owner/services']);
            } else {
                Yii::$app->session->setFlash('error', 'Error creating service: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('create-service', [
            'model' => $model,
        ]);
    }
    public function actionUpdateService($id)
    {
        $model = Services::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException("Service not found");
        }

        $request = Yii::$app->request;
        if ($request->isAjax) {
            return $this->renderAjax('_edit_form', ['model' => $model]);
        }

        if ($model->load($request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Service has been successfully updated");
            return $this->redirect(['services']);
        }

        return $this->render('update-service', ['model' => $model]);
    }
    public function actionDisableService()
    {
        $id = Yii::$app->request->post('id');
        $service = Services::findOne($id);

        if ($service) {
            $service->status = 'inactive';
            if ($service->save()) {
                return json_encode(['success' => true, 'message' => 'Service disabled successfully.']);
            }
        }

        return json_encode(['success' => false, 'message' => 'Failed to disable service.']);
    }

    // products management
    public function actionProducts()
    {
        $this->layout = 'ownerLayout';

        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();

        if ($salon === null) {
            Yii::$app->session->setFlash('error', 'Please create a salon first.');
            return $this->redirect(['salon-owner/create-salon']);
        }

        $model = new ProductsModel();
        $products = ProductsModel::find()->where(['salon_id' => $salon->id, 'status' => 'active'])->all();

        return $this->render('products', [
            'salon' => $salon,
            'model' => $model,
            'products' => $products,
            'salon_id' => $salon->id,
        ]);
    }

    public function actionCreateProducts()
    {
        $model = new ProductsModel();
        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();

        if ($salon !== null) {
            $model->salon_id = $salon->id;
        } else {
            Yii::$app->session->setFlash('error', 'Salon not found. Please create a salon first.');
            return $this->redirect(['salon-owner/create-products']);
        }

        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'image');
            if ($file) {
                $model->image = 'uploads/' . uniqid('product_') . '.' . $file->extension;
                $file->saveAs($model->image);
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Product added successfully.');
                return $this->redirect(['salon-owner/products']);
            } else {
                Yii::$app->session->setFlash('error', 'Error creating product: ' . implode(', ', $model->getFirstErrors()));
            }
        }

        return $this->render('create-products', [
            'model' => $model,
        ]);
    }
   

    protected function findModel($id)
    {
        if (($model = SalonModel::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
