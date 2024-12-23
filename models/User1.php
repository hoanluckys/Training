<?php

namespace app\models;

use Yii;

use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string|null $role
 * @property string|null $description
 *
 * @property Project[] $projects
 * @property Projectstaff[] $projectstaff
 */
class User1 extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'name', 'email'], 'required', 'message' => 'không được để trống.'],
            [['description'], 'string', 'message' => 'phải là một chuỗi'],
            [['username', 'role'], 'string', 'max' => 50, 'message' => 'chỉ được phép tối đa 50 kí tự'],
            [['password'], 'string', 'max' => 255, 'message' => 'chỉ được phép tối đa 255 kí tự'],
            [['name', 'email'], 'string', 'max' => 100, 'message' => 'chỉ được phép tối đa 100 kí tự'],
            [['username'], 'unique', 'message' => 'đã tồn tại trên hệ thống'],
            [['email'], 'unique', 'message' => 'đã tồn tại trên hệ thống'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'email' => 'Email',
            'role' => 'Role',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Projects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['projectManagerId' => 'id']);
    }

    /**
     * Gets query for [[Projectstaff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectstaff()
    {
        return $this->hasMany(Projectstaff::class, ['userId' => 'id']);
    }

    public function validatePassword($password)
    {
        Yii::error("Password incorrect for user: " . $this->username);
        return $this->password === $password;
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return null;
    }


    public function validateAuthKey($authKey)
    {
        return false;
    }

    public function getRoles()
    {
        return $this->role;
    }

}
