<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salon".
 *
 * @property int $id
 * @property string $name
 * @property int|null $owner_id
 * @property string|null $status
 * @property string|null $type
 * @property string|null $address
 * @property string|null $description
 * @property string|null $working_days
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $salon_image
 *
 * @property Appointments[] $appointments
 * @property Users $owner
 * @property Products[] $products
 * @property Services[] $services
 */
class Salon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salon';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['owner_id'], 'default', 'value' => null],
            [['owner_id'], 'integer'],
            [['description'], 'string'],
            [['working_days', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['status', 'type'], 'string', 'max' => 20],
            [['address', 'salon_image'], 'string', 'max' => 255],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'owner_id' => 'Owner ID',
            'status' => 'Status',
            'type' => 'Type',
            'address' => 'Address',
            'description' => 'Description',
            'working_days' => 'Working Days',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'salon_image' => 'Salon Image',
        ];
    }

    /**
     * Gets query for [[Appointments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointments::class, ['salon_id' => 'id']);
    }

    /**
     * Gets query for [[Owner]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Users::class, ['id' => 'owner_id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['salon_id' => 'id']);
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices()
    {
        return $this->hasMany(Services::class, ['salon_id' => 'id']);
    }
}
