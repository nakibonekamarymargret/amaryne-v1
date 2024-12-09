<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $profileimage
 * @property string|null $contact
 * @property string $username
 * @property string|null $role
 * @property string|null $verification_token
 * @property int|null $is_verified
 *
 * @property Appointments[] $appointments
 * @property AuditLog[] $auditLogs
 * @property Notifications[] $notifications
 * @property Orders[] $orders
 * @property Salon[] $salons
 */
class CustomerModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'username'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_verified'], 'default', 'value' => null],
            [['is_verified'], 'integer'],
            [['name', 'password', 'profileimage', 'username', 'role', 'verification_token'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            [['status', 'contact'], 'string', 'max' => 20],
            [['email'], 'unique'],
            [['username'], 'unique'],
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
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'profileimage' => 'Profileimage',
            'contact' => 'Contact',
            'username' => 'Username',
            'role' => 'Role',
            'verification_token' => 'Verification Token',
            'is_verified' => 'Is Verified',
        ];
    }

    /**
     * Gets query for [[Appointments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointments::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[AuditLogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditLogs()
    {
        return $this->hasMany(AuditLog::class, ['performed_by' => 'id']);
    }

    /**
     * Gets query for [[Notifications]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifications()
    {
        return $this->hasMany(Notifications::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Salons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSalons()
    {
        return $this->hasMany(Salon::class, ['owner_id' => 'id']);
    }
}
