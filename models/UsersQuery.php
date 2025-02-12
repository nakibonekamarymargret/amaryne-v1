<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Register]].
 *
 * @see Register
 */
class UsersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Register[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Register|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
