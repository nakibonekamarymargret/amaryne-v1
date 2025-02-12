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
    public function actionIndex($type = null)
    {
        // Fetch popular hair salons with service count
        $popularHairSalons = $this->getSalonsByType(2, 4);

        // Fetch popular nail clinics with service count
        $popularNailClinics = $this->getSalonsByType(3, 4);

        // Fetch beauty shops
        $beautyShops = $this->getSalonsByType(6);
        $otherSalons = $this->getSalonsByType(null, 4);

        $query = SalonModel::find()
            ->select(['salon.*', 'COUNT(services.id) AS service_count'])
            ->joinWith('services')
            ->groupBy('salon.id')
            ->orderBy(['service_count' => SORT_DESC]);

        if ($type) {
            $query->andWhere(['salon.type' => $type]);
        }

        $salons = $query->all();
        $filteredSalons = [];
        if ($type) {
            $filteredSalons = SalonModel::find()
                ->select(['salon.*', 'COUNT(services.id) AS service_count'])
                ->joinWith('services')
                ->where(['salon.type' => $type])
                ->groupBy('salon.id')
                ->orderBy(['service_count' => SORT_DESC])
                ->all();
        }
        // Fetch all salons sorted by service count (for the second div)
    $allSalons = SalonModel::find()
    ->select(['salon.*', 'COUNT(services.id) AS service_count'])
    ->joinWith('services')
    ->groupBy('salon.id')
    ->orderBy(['service_count' => SORT_DESC])
    ->all();

        // Pass the sidebar data and salons to the view
        $this->view->params['sidebarData'] = [
            'popularHairSalons' => $popularHairSalons,
            'popularNailClinics' => $popularNailClinics,
            'beautyShops' => $beautyShops,
            'otherSalons' => $otherSalons
        ];

        return $this->render('index', [
            'salons' => $salons,
            'filteredSalons' => $filteredSalons,
            'allSalons' => $allSalons,
        ]);
    }

    public function actionView($id)
    {
        $salon = SalonModel::findOne($id);

        if (!$salon) {
            throw new NotFoundHttpException('Salon not found.');
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

    private function getSalonsByType($type = null, $limit = null)
    {
        $query = SalonModel::find()
            ->select(['salon.*', 'COUNT(services.id) AS service_count'])
            ->joinWith('services')
            ->groupBy('salon.id')
            ->orderBy(['service_count' => SORT_DESC]);

        if ($type) {
            $query->andWhere(['salon.type' => $type]);
        }

        if ($limit) {
            $query->limit($limit);
        }

        return $query->all();
    }
}


