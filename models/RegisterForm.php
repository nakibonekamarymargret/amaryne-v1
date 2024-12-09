<?php
namespace app\models;

use app\models\query\RegisterFormQuery;

use Yii;
class RegisterForm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    public $verification_token;

    // Add 'verification_token' to the rules
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'username'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'password', 'username', 'verification_token'], 'string', 'max' => 255],
            [['email'], 'string', 'max' => 100],
            ['is_verified', 'boolean'],
            [['contact'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Contact must contain only digits.'],
            [['contact'], 'string', 'min' => 10, 'max' => 16, 'tooShort' => 'Contact must be at least 10 characters.', 'tooLong' => 'Contact must be at most 16 characters.'],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['role'], 'safe'],
            [['profileimage'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg, png'],
            [
                'password',
                'match',
                'pattern' => '/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/',
                'message' => 'Enter a strong password with at least 8 characters, including uppercase and lowercase letters.',
            ],
        ];
    }
  
    public function upload()
    {
        if ($this->validate()) {
            $filePath = 'uploads/' . $this->profileimage->baseName . '.' . $this->profileimage->extension;
            if ($this->profileimage->saveAs($filePath)) {
                return true;
            }
        }
        return false;
    }
    public function assignRole($roleName)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if ($role) {
            $auth->assign($role, $this->id);
        } else {
            throw new \Exception("Role '{$roleName}' not found");
        }
    }

    public function beforeSave($insert)
{
    if (parent::beforeSave($insert)) {
        if ($this->isNewRecord) {
            $this->verification_token = Yii::$app->security->generateRandomString(); // Generate a verification token
        }
        return true;
    }
    return false;
}


}