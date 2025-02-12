<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $id
 * @property int|null $salon_id
 * @property string $name
 * @property float $price
 * @property string|null $description
 * @property string|null $image
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property float|null $discount
 * @property int|null $stock
 *
 * @property OrderItems[] $orderItems
 * @property Salon $salon
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salon_id', 'stock'], 'default', 'value' => null],
            [['salon_id', 'stock'], 'integer'],
            [['name', 'price'], 'required'],
            [['price', 'discount'], 'number'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 20],
            [['salon_id'], 'exist', 'skipOnError' => true, 'targetClass' => Salon::class, 'targetAttribute' => ['salon_id' => 'id']],
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
            'price' => 'Price',
            'description' => 'Description',
            'image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'discount' => 'Discount',
            'stock' => 'Stock',
        ];
    }

    /**
     * Gets query for [[OrderItems]].
     *
     * @return \yii\db\ActiveQuery|OrderItemsQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItems::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Salon]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getSalon()
    {
        return $this->hasOne(Salon::class, ['id' => 'salon_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProductsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProductsQuery(get_called_class());
    }
}
