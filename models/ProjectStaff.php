<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "projectstaff".
 *
 * @property int $id
 * @property int $projectId
 * @property int $userId
 *
 * @property Project $project
 * @property User $user
 */
class ProjectStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'projectstaff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['projectId', 'userId'], 'required'],
            [['projectId', 'userId'], 'integer'],
            [['projectId'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['projectId' => 'id']],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User1::class, 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'projectId' => 'Project ID',
            'userId' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'projectId']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User1::class, ['id' => 'userId']);
    }
}
