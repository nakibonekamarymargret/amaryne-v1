<?php

namespace app\controllers;

use app\models\Orders;
use app\models\Products;
use app\models\SalonModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class ProductsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $topSellers = Products::find()->orderBy(['price' => SORT_DESC])->limit(5)->all();
        $products = Products::find()
            ->orderBy(['price' => SORT_DESC])
            ->all();
        $this->view->params['sidebarData'] = [
            'topSellers' => $topSellers
        ];

        return $this->render('index', [
            'products' => $products
        ]);
    }


    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
        $model = new Products();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionMakeOrder()
    {
        $model = new Orders();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            if ($model->save()) {
                return ['success' => true, 'message' => 'Order placed successfully!'];
            }

            return ['success' => false, 'errors' => $model->errors];
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }
    public function actionOrderDetails($id)
    {
        $product = Products::findOne($id);
        if ($product) {
            return $this->renderPartial('_order_modal', [
                'product' => $product,
            ]);
        } else {
            return 'Product not found';
        }
    }
    public function actionOrderProduct($productId)
    {
        // Create an order for a product
        $order = new Orders();
        $order->customer_id = Yii::$app->user->id;
        $order->total_price = Products::findOne($productId)->price;

        if ($order->save()) {
            $product = Products::findOne($productId);
            $product->stock -= 1;
            $product->save();

            return $this->redirect(['orders/view', 'id' => $order->id]);
        }

        throw new \yii\web\ServerErrorHttpException('Failed to create order.');
    }
   
    protected function findModel($id)
    {
        if (($model = Products::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
