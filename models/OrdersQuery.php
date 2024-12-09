<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[OrdersModel]].
 *
 * @see OrdersModel
 */
class OrdersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return OrdersModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return OrdersModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
