<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductsModel]].
 *
 * @see ProductsModel
 */
class ProductsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductsModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductsModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    public function byKeyword($keyword)
    {
        return $this->andWhere("MATCH(name, description, price) AGAINST (:keyword)", ['keyword' => $keyword]);
    }
}
