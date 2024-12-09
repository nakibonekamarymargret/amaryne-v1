<?php

namespace app\controllers;

use app\models\Appointments;
use app\models\CustomerModel;
use app\models\Services;
use app\models\User;
use Yii;
use yii\web\Controller;
use app\models\SalonModel;
use yii\web\NotFoundHttpException;

class SalonsController extends Controller
{
    public function actionIndex()
    {
        $popularHairSalons = SalonModel::find()
            ->select(['salon.*', 'COUNT(services.id) AS service_count'])
            ->joinWith('services')
            ->where(['salon.type' => 2])
            ->groupBy('salon.id')
            ->orderBy(['service_count' => SORT_DESC])
            ->limit(4)
            ->all();
        $popularNailClinics = SalonModel::find()
            ->select(['salon.*', 'COUNT(services.id) AS service_count'])
            ->joinWith('services')
            ->where(['salon.type' => 3])
            ->groupBy('salon.id')
            ->orderBy(['service_count' => SORT_DESC])
            ->limit(4)
            ->all();

        // Fetch beauty shops
        $beautyShops = SalonModel::find()
            ->select(['salon.*'])
            ->where(['salon.type' => 6])
            ->orderBy(['name' => SORT_ASC])
            ->all();

        // Fetch other types
        $otherSalons = SalonModel::find()
            ->select(['salon.*'])
            ->where(['NOT IN', 'salon.type', [1, 3, 4, 5]])
            ->orderBy(['name' => SORT_ASC])
            ->limit(4) // Limit here
            ->all();
        $salons = SalonModel::find()
            ->select(['salon.*', 'COUNT(services.id) AS service_count'])
            ->joinWith('services')
            ->groupBy('salon.id')
            ->orderBy(['service_count' => SORT_DESC])
            ->all();
        $this->view->params['sidebarData'] = [
            'popularHairSalons' => $popularHairSalons,
            'popularNailClinics' => $popularNailClinics,
            'beautyShops' => $beautyShops,
            'otherSalons' => $otherSalons
        ];

        return $this->render('index', [
            'salons' => $salons
        ]);
    }

     public function actionView($id)
    {
        $salon = SalonModel::findOne($id);

        if (!$salon) {
            throw new \yii\web\NotFoundHttpException('Salon not found.');
        }

        $services = $salon->getServices()->where(['status' => 'active'])->all();
        $appointment = new Appointments();
        $customer = Yii::$app->user->identity;
        return $this->render('view', [
            'salon' => $salon,
            'services' => $services,
            'appointment' => $appointment,
            'customer' => $customer,
        ]);
    }

}

