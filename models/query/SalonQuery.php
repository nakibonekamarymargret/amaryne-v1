<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[SalonModel]].
 *
 * @see SalonModel
 */
class SalonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SalonModel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SalonModel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
