<?php

namespace app\models;

use Yii;


class Register extends \yii\db\ActiveRecord
{
   
    public static function tableName()
    {
        return 'users';
    }

  
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'username'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_verified'], 'default', 'value' => null],
            [['is_verified'], 'integer'],
            [['name', 'password', 'profileimage', 'username', 'role', 'auth_key'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['status', 'contact'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['username'], 'unique'],
        ];
    }


    public function getAppointments()
    {
        return $this->hasMany(Appointments::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[AuditLogs]].
     *
     * @return \yii\db\ActiveQuery|AuditLogQuery
     */
    public function getAuditLogs()
    {
        return $this->hasMany(AuditLog::class, ['performed_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery|NotificationsQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Salons]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getSalons()
    {
        return $this->hasMany(Salon::class, ['owner_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
