<?php
namespace app\controllers;

use app\models\Appointments;
use app\models\OrderItems;
use app\models\Products;
use app\models\Orders;
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
    
        // Fetch salon info for the logged-in owner
        $salon = SalonModel::find()->where(['owner_id' => Yii::$app->user->id])->one();
        $salonName = $salon ? $salon->name : 'amaryne Salonist';
    
        if (!$salon) {
            throw new NotFoundHttpException('Salon not found for the logged-in user.');
        }
    
        // Fetch services created by the logged-in salon owner
        $servicesCount = Services::find()
            ->where(['salon_id' => $salon->id, 'status' => 'active'])
            ->count();
    
        // Query to fetch clients linked to orders or appointments of this salon
        $clientsQuery = (new \yii\db\Query())
            ->select('u.id, u.name, u.email, u.contact, u.status')
            ->from('users u')
            ->leftJoin(
                ['orders' => Orders::find()
                    ->select('customer_id')
                    ->innerJoin('order_items oi', 'oi.order_id = orders.id')
                    ->innerJoin('products p', 'oi.product_id = p.id')
                    ->where(['p.salon_id' => $salon->id])
                    ->distinct()],
                'u.id = orders.customer_id'
            )
            ->leftJoin(
                ['appointments' => Appointments::find()
                    ->select('customer_id')
                    ->where(['salon_id' => $salon->id])
                    ->distinct()],
                'u.id = appointments.customer_id'
            )
            ->where(['u.role' => 'customer'])
            ->andWhere([
                'or',
                ['is not', 'orders.customer_id', null],
                ['is not', 'appointments.customer_id', null]
            ])
            ->distinct();
    
        // Pagination for clients
        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $clientsQuery->count(),
        ]);
        $clients = $clientsQuery->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
    
        // Fetch orders related to this salon
        $ordersQuery = (new \yii\db\Query())
            ->select(['o.id', 'MAX(u.name) AS customer_name', 'SUM(oi.quantity * p.price) AS total_price', 'SUM(oi.quantity) AS total_quantity'])
            ->from('orders o')
            ->innerJoin('order_items oi', 'oi.order_id = o.id')
            ->innerJoin('products p', 'oi.product_id = p.id')
            ->innerJoin('users u', 'u.id = o.customer_id')
            ->where(['p.salon_id' => 57]) // Make sure to use the correct salon ID
            ->groupBy(['o.id'])
            ->orderBy(['o.created_at' => SORT_DESC]);
    
        $ordersPagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $ordersQuery->count(),
        ]);
        $orders = $ordersQuery->offset($ordersPagination->offset)
            ->limit($ordersPagination->limit)
            ->all();
    
        // Count statistics
        $totalClientsCount = $clientsQuery->count();
        $activeClientsCount = Appointments::find()
            ->where(['salon_id' => $salon->id])
            ->andWhere(['>=', 'appointment_date', date('Y-m-d', strtotime('-30 days'))])
            ->distinct('customer_id')
            ->count();
    
        $appointmentsCount = Appointments::find()
            ->where(['status' => 'active', 'salon_id' => $salon->id])
            ->count();
    
        $ordersCount = Orders::find()
            ->innerJoin('order_items oi', 'oi.order_id = orders.id')
            ->innerJoin('products p', 'oi.product_id = p.id')
            ->where(['p.salon_id' => $salon->id])
            ->distinct('orders.id')
            ->count();
    
        $productsCount = Products::find()
            ->where(['salon_id' => $salon->id, 'status' => 'active'])
            ->count();
    
        return $this->render('dashboard', [
            'model' => Yii::$app->user->identity,
            'salonName' => $salonName,
            'clients' => $clients,
            'pagination' => $pagination,
            'orders' => $orders,
            'ordersPagination' => $ordersPagination,
            'totalClientsCount' => $totalClientsCount,
            'activeClientsCount' => $activeClientsCount,
            'appointmentsCount' => $appointmentsCount,
            'ordersCount' => $ordersCount,
            'productsCount' => $productsCount,
            'servicesCount' => $servicesCount,
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

        $model = new Products();
        $products = Products::find()->where(['salon_id' => $salon->id, 'status' => 'active'])->all();

        return $this->render('products', [
            'salon' => $salon,
            'model' => $model,
            'products' => $products,
            'salon_id' => $salon->id,
        ]);
    }

    public function actionCreateProducts()
    {
        $model = new Products();
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
