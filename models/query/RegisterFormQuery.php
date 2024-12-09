<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[RegisterForm]].
 *
 * @see RegisterForm
 */
class RegisterFormQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return RegisterForm[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return RegisterForm|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
