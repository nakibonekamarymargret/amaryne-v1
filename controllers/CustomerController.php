<?php

namespace app\controllers;

use app\models\Appointments;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\SalonModel;
use Yii;
use app\models\User;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class CustomerController extends Controller
{
    public function actionIndex()
    {
        $this->layout = false;
        $salons = SalonModel::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', ['salons' => $salons]);
    }
    public function actionRegister()
    {
        $this->layout = false;

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->role = User::ROLE_CUSTOMER;
            $file = UploadedFile::getInstance($model, 'profileimage');
            if ($file) {
                $model->profileimage = 'uploads/' . uniqid('users/') . '.' . $file->extension;
                $file->saveAs($model->profileimage);
            }

            $model->password = Yii::$app->security->generatePasswordHash($model->password);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registration successful.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }
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
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionAppointment($salon_id)
    {
        $appointment = new Appointments();
        $user = Yii::$app->user->identity;
    
        if ($appointment->load(Yii::$app->request->post())) {
            $appointment->salon_id = $salon_id;
            $appointment->customer_id = $user->id;
    
            if ($appointment->save()) {
                Yii::$app->session->setFlash('success', 'Appointment made successfully');
                return $this->redirect(['salons/view', 'id' => $salon_id]);
            }
             else {
                Yii::$app->session->setFlash('error', 'Failed to create an appointment.');
            }
        }
    
        return $this->render('salons/view', [
            'appointment' => $appointment,
            'user' => $user,
        ]);
    }
    public function actionMakeOrder(){
    
    }
    
}