<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "services".
 *
 * @property int $id
 * @property int $salon_id
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property float|null $discount
 * @property string|null $service_image
 *
 * @property Salon $salon
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salon_id', 'name', 'price'], 'required'],
            [['salon_id'], 'default', 'value' => null],
            [['salon_id'], 'integer'],
            [['description'], 'string'],
            [['price', 'discount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
            [['salon_id'], 'exist', 'skipOnError' => true, 'targetClass' => SalonModel::class, 'targetAttribute' => ['salon_id' => 'id']],
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
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'discount' => 'Discount',
            'service_image' => 'Service Image',
        ];
    }


    public function getSalon()
    {
        return $this->hasOne(SalonModel::class, ['id' => 'salon_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord && !isset($this->salon_id)) {
                $this->salon_id = Yii::$app->request->get('salonId');
            }
            return true;
        }
        return false;
    }
}
