<?php
namespace app\models;

use Yii;
use \yii\web\IdentityInterface;
use yii\db\ActiveRecord;

class User extends ActiveRecord  implements IdentityInterface
{
    const ROLE_CUSTOMER = 'customer';
    const ROLE_SALON_OWNER = 'salon owner';
    const ROLE_ADMIN = 'admin';
    public $authKey;
    public static function tableName(){
     return  'users';
    }


    /* *
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    //return null;
    
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }


    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    public function validateEmail($email)
    {
        return $user = User::find()->where('email=:email', ['email' => $email])->exists();
    }
    //email
    public function uniqueEmail($attribute)
    {
        $user = static::findOne(['email' => $this->$attribute]);
        if ($user && !$user->verifyEmail) {
            $this->addError($attribute, 'This email is already in use');
        }
    }
    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }
    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
    // generating auth key
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
    // public function getTelephone()
    // {
    //     return $this->telephone;
    // }
}
