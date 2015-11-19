<?php

namespace common\models;

use Yii;
use yii\helpers\Json;
use \yii\db\Query;

/**
 * This is the model class for table "projects".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $logo
 *
 * @property Sections[] $sections
 */
class Projects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'required'],
            [['description'], 'string'],
            [['title', 'logo'], 'string', 'max' => 255]
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
            'description' => 'Description',
            'logo' => 'Logo',
        ];
    }

    public function beforeDelete()
    {
        parent::beforeDelete();

        $sections = $this->getSections()->all();

        if (!empty($sections)) {
            foreach ($sections as $section) {
                $section->delete();
            }
        }

        $this->deleteLogoImage();

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSections()
    {
        return $this->hasMany(Sections::className(), ['project_id' => 'id']);
    }

    public function getProjectsTreeJSON()
    {
        $projects = $this->find()->with('sections')->asArray()->all();

        if (!empty($projects)) {
            foreach($projects as $key => $project) {
                $model = (new self())->find()->where(['id' => $project['id']])->one();
                $projects[$key]['triggers'] = $model->getTriggers();
            }
        }
        return Json::encode($projects);
    }

    public function getProjectWithSections($id)
    {
        return $this->find()->where(['id' => $id])->with('sections')->asArray()->one();
    }

    public function getWarningTriggers()
    {
        $triggers = $this->getTriggers();
    }

    public function getTriggers()
    {
        $fields = [
            'triggers.title as trigger_title',
            'triggers.id as trigger_id',
            'sections.title as section_title',
            'sections.id as section_id'
        ];

        $triggers = (new Query())->select($fields)
                              ->from('sections')
                              ->join('INNER JOIN', 'triggers', 'triggers.section_id = sections.id')
                              ->where('sections.project_id = :project_id', array(':project_id' => $this->id))
                              ->orderBy(['sections.id' => SORT_ASC, 'triggers.title' => SORT_ASC])
                              ->all();

        if (!empty($triggers)) {
            foreach ($triggers as $key => $trigger) {
                $triggers[$key]['last_message'] = (new Triggers())->find()
                                                                  ->where(['id' => $trigger['trigger_id']])
                                                                  ->one()
                                                                  ->getLastMessage();
            }
        }

        return $triggers;
    }

    public function deleteLogo()
    {
        if ($this->deleteLogoImage()) {
            $this->logo = '';
            $this->save();
            return true;
        }

        return false;
    }

    public function deleteLogoImage()
    {
        if (!isset($this->logo)) {
            return false;
        }

        try {
            unlink(Yii::getAlias('@webroot/upload/logos') . '/' . $this->logo);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    public function getSchedule()
    {
        $events = (new Events())->find()->with(['trigger' => function($query) {
                                                                $query->andWhere('is_active = 1');
                                                             }
                                              ])
                                        ->where(['is_show' => 1])
                                        ->orderBy(['time_to_start' => SORT_ASC])
                                        ->asArray()
                                        ->all();

        $result = array();

        if (empty($events)) {
            return $result;
        }

        $message_classes = array('success' => 'success', 'error' => 'danger', 'system error' => 'danger', 'normal' => 'info');

        foreach ($events as $key => $event) {
            $message = (new Events())->find()->where(['id' => $event['id']])->one()->getLastMessage();
            if ($message->created_date > date('Y-m-d 00:00:00')) {
                $events[$key]['last_message'] = $message;
                $events[$key]['message_class'] = $message_classes[$message->message_type];
            }
        }

        return $events;
    }

    static public function searchProjects($query)
    {
        $result = (new self())->find()
                              ->where('title LIKE :query OR description LIKE :query', array(':query' => "%{$query}%"))
                              ->all();
        return $result;
    }
}
