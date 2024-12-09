<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "appointments".
 *
 * @property int $id
 * @property int|null $salon_id
 * @property int|null $customer_id
 * @property int|null $service_id
 * @property string|null $status
 * @property string|null $appointment_date
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $appointment_time
 *
 * @property User $customer
 * @property SalonModel $salon
 * @property Services $service
 */
class Appointments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'appointments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salon_id', 'customer_id', 'service_id'], 'default', 'value' => null],
            [['salon_id', 'customer_id', 'service_id'], 'integer'],
            [['appointment_date', 'created_at', 'updated_at'], 'safe'],
            [['appointment_time'], 'string'],
            [['status'], 'string', 'max' => 20],
            [['salon_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalonModel::class, 'targetAttribute' => ['salon_id' => 'id']],
            [['service_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['service_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'salon_id' => 'Salon ID',
            'customer_id' => 'Customer ID',
            'service_id' => 'Service ID',
            'status' => 'Status',
            'appointment_date' => 'Appointment Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'appointment_time' => 'Appointment Time',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[SalonModel]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(SalonModel::class, ['id' => 'salon_id']);
    }

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Services::class, ['id' => 'service_id']);
    }
}
