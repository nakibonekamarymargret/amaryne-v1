<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

class SalonModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salon';
    }

    /**
     * @var UploadedFile
     */

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'owner_id', 'description'], 'required'],
            [['owner_id'], 'integer'],
            [['description'], 'string'],
            [['working_days', 'type', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
            [['address',], 'string', 'max' => 255],
            [['owner_id'], 'default', 'value' => null],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::class, ['id' => 'owner_id']);
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->type)) {
                $this->type = implode(', ', $this->type);
            }

            // if ($this->salon_image && !empty($this->salon_image)) {
            //     $this->salon_image = 'uploads/' . uniqid('salons/') . '.' . pathinfo($this->salon_image, PATHINFO_EXTENSION);
            // }

            return true;
        }
        return false;
    }
    public function getSalonTypeLabels()
    {
        return [
            1 => 'Bridal Salon',
            2 => 'Hair Salon',
            3 => 'MANI + PEDI SALON',
            4 => 'Barber Shop',
            5 => 'Skin Care Clinic',
        ];
    }

    public function getFormattedTypes()
    {
        $typeLabels = $this->getSalonTypeLabels();
        $types = is_array($this->type) ? $this->type : explode(', ', $this->type);

        return implode(', ', array_map(function ($type) use ($typeLabels) {
            return $typeLabels[$type] ?? $type;
        }, $types));
    }
    public function getFormattedWorkingDays()
    {
        $dayLabels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $workingDays = is_array($this->working_days) ? $this->working_days : explode(', ', $this->working_days);

        return implode(', ', array_map(function ($day) use ($dayLabels) {
            return $dayLabels[$day] ?? 'Invalid Day'; 
        }, $workingDays));
    }
    
    /**
     * Uploads the salon image.
     *
     * @return bool whether the upload succeeded
     */
    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->salon_image->baseName . '.' . $this->salon_image->extension;
            if ($this->salon_image->saveAs($filePath)) {
                return true;
            }
        }
        return false;
    }
   public function getServices(){
        
        return $this->hasMany(Services::class, ['salon_id'=> 'id']);
   }
   public function getCustomer()
    {
        return $this->hasOne(CustomerModel::class, ['id' => 'customer_id']);
    }
    public function getAppointments()
    {
        return $this->hasMany(Appointments::class, ['salon_id' => 'id']);
    }
    public function getProducts()
    {
        return $this->hasMany(ProductsModel::class, ['salon_id' => 'id']);
    }
}
