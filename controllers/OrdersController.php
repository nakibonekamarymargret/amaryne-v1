<?php

namespace app\controllers;
use app\models\OrderItems;
use app\models\OrderItemsModel;
use app\models\Products;
use Yii;
use app\models\Orders;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;

class OrdersController extends Controller
{

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
        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionCreate()
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionPurchase()
    {
        if (!Yii::$app->request->isPost) {
            return $this->asJson(['success' => false, 'message' => 'Invalid request method']);
        }

        try {
            $cart = Yii::$app->request->post('cart');
            if (empty($cart)) {
                throw new \yii\base\UserException('Cart is empty.');
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                // Create Order
                $order = new Orders();
                $order->customer_id = Yii::$app->user->id;
                $order->total_price = array_sum(array_column($cart, 'price'));
                if (!$order->save()) {
                    throw new \yii\db\Exception('Failed to save order.');
                }

                // Add Order Items and Update Stock
                foreach ($cart as $item) {
                    // Save order item
                    $orderItem = new OrderItems();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item['id'];
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    if (!$orderItem->save()) {
                        throw new \yii\db\Exception('Failed to save order item.');
                    }

                    // Update product stock
                    $product = Products::findOne($item['id']);
                    if ($product === null) {
                        throw new \yii\db\Exception("Product not found: {$item['name']}");
                    }
                    if ($product->stock < $item['quantity']) {
                        throw new \yii\db\Exception("Insufficient stock for {$product->name}.");
                    }
                    $product->stock -= $item['quantity'];
                    if (!$product->save()) {
                        throw new \yii\db\Exception("Failed to update stock for {$product->name}.");
                    }
                }

                $transaction->commit();
                return $this->asJson([
                    'success' => true,
                    'orderId' => $order->id,
                    'message' => 'Purchase successful.'
                ]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $this->asJson([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        } catch (\yii\base\UserException $e) {
            return $this->asJson(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function actionView($id)
    {
        $model = Orders::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Order not found.');
        }

        $orderItems = OrderItems::find()->where(['order_id' => $id])->all();

        return $this->asJson([
            'success' => true,
            'order' => $model,
            'items' => $orderItems,
        ]);
    }
    public function actionCartItems()
    {
        $cart = Yii::$app->session->get('cart', []);

        $products = Products::findAll(array_keys($cart));

        return $this->renderPartial('/products/_order_modal', [
            'products' => $products,
            'cart' => $cart,
        ]);
    }

    public function actionAddToCart($productId, $productName, $productPrice) {
        // Initialize the cart session if not already set
        if (!isset(Yii::$app->session['cart'])) {
            Yii::$app->session['cart'] = [];
        }
    
        // Add product to cart
        $cart = Yii::$app->session['cart'];
        if (!isset($cart[$productId])) {
            $cart[$productId] = ['name' => $productName, 'price' => $productPrice, 'quantity' => 0];
        }
        $cart[$productId]['quantity']++;
        Yii::$app->session['cart'] = $cart;
    
        return $this->redirect(['product/index']);
    }
    
    public function actionCheckout() {
        $cart = Yii::$app->session['cart'] ?? [];
        $totalPrice = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
    
        return $this->render('checkout', [
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }
    


    protected function findModel($id)
    {
        if (($model = Orders::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
