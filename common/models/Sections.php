<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sections".
 *
 * @property integer $id
 * @property string $title
 * @property integer $project_id
 *
 * @property Projects $project
 * @property Triggers[] $triggers
 */
class Sections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sections';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'project_id'], 'required'],
            [['project_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'project_id' => 'Project ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Projects::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriggers()
    {
        return $this->hasMany(Triggers::className(), ['section_id' => 'id']);
    }

    public function getSectionsWithProjects()
    {
        return $this->find()->with('project')->asArray()->all();
    }

    public function getSectionWithTriggers($id)
    {
        return $this->find()->where(['id' => $id])->with('triggers')->asArray()->one();
    }

    static public function searchSections($query)
    {
        $result = (new self())->find()
                              ->where('title LIKE :query', array(':query' => "%{$query}%"))
                              ->all();
        return $result;
    }
}
