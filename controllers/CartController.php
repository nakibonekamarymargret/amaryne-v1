<?php


namespace app\controllers;

use app\models\Products;
use Yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Product;

class CartController extends Controller
{
    public function actionAddToCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $productId = Yii::$app->request->post('productId');
        $quantity = Yii::$app->request->post('quantity', 1);

        $cart = Yii::$app->session->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $product = Products::findOne($productId);
            if ($product) {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => $quantity,
                ];
            }
        }
        Yii::$app->session->set('cart', $cart);

        return ['success' => true, 'cart' => $cart];
    }

    public function actionRemoveFromCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $productId = Yii::$app->request->post('productId');

        $cart = Yii::$app->session->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }
        Yii::$app->session->set('cart', $cart);

        return ['success' => true, 'cart' => $cart];
    }

    public function actionGetCart()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $cart = Yii::$app->session->get('cart', []);
        return ['cart' => $cart];
    }
}
