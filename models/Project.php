<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property int $projectManagerId
 * @property string|null $description
 * @property string|null $createDate
 * @property string|null $updateDate
 *
 * @property User $projectManager
 * @property Projectstaff[] $projectstaff
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'projectManagerId'], 'required'],
            [['projectManagerId'], 'integer'],
            [['description'], 'string'],
            [['createDate', 'updateDate'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['projectManagerId'], 'exist', 'skipOnError' => true, 'targetClass' => User1::class, 'targetAttribute' => ['projectManagerId' => 'id']],
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
            'projectManagerId' => 'Project Manager ID',
            'description' => 'Description',
            'createDate' => 'Create Date',
            'updateDate' => 'Update Date',
        ];
    }

    /**
     * Gets query for [[ProjectManager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectManager()
    {
        return $this->hasOne(User1::class, ['id' => 'projectManagerId']);
    }

    /**
     * Gets query for [[Projectstaff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectstaff()
    {
        return $this->hasMany(Projectstaff::class, ['projectId' => 'id']);
    }
}
