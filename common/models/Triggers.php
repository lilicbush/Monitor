<?php

namespace common\models;

use Yii;
use yii\base\Event;
use \yii\db\Query;
use common\models\Messages;
use yii\db\QueryBuilder;

/**
 * This is the model class for table "triggers".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $importance
 * @property string $last_launch
 * @property integer $db_id
 * @property integer $section_id
 * @property integer $user_create
 * @property integer $is_active
 * @property integer $trigger_type
 * @property string $code
 *
 * @property Events[] $events
 * @property Messages[] $messages
 * @property Databases $db
 * @property Sections $section
 */
class Triggers extends \yii\db\ActiveRecord
{
    public $full_info;
    private $_count_in_page = 30;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'triggers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'importance', 'db_id', 'section_id', 'user_create', 'is_active', 'trigger_type', 'code'], 'required'],
            [['description', 'code'], 'string'],
            [['importance', 'db_id', 'section_id', 'user_create', 'is_active', 'trigger_type'], 'integer'],
            [['last_launch'], 'safe'],
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
            'description' => 'Description',
            'importance' => 'Importance',
            'last_launch' => 'Last Launch',
            'db_id' => 'Db ID',
            'section_id' => 'Section ID',
            'user_create' => 'User Create',
            'is_active' => 'Is Active',
            'trigger_type' => 'Trigger Type',
            'code' => 'Code',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['trigger_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['trigger_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Sections::className(), ['id' => 'section_id']);
    }

    public function getImportanceItems()
    {
        $items = (new Query())->select(['id', 'title', 'color'])
                                       ->from('triggers_importance')
                                       ->all();
        return $items;
    }

    public function getTypes()
    {
        $types = (new Query())->select(['id', 'title'])
                              ->from('triggers_types')
                              ->all();
        return $types;
    }

    public function getFullTriggerInfo()
    {
        if (empty($this->full_info)) {
            $this->_setFullTriggerInfo();
        }

        return $this->full_info;
    }

    private function _setFullTriggerInfo()
    {
        $db_model = (new Databases())->find()->where(['id' => $this->db_id])->one();
        $events_model = new Events();

        $this->full_info['db'] = $db_model->title;
        $this->full_info['importance_set'] = $this->getImportanceSet();
        $this->full_info['type'] = $this->getTypeText();

        $section = $this->getSection()->one();
        $this->full_info['section'] = ['id' => $section->id, 'title' => $section->title];

        $project = (new Projects())->find()->where(['id' => $section->project_id])->one();
        $this->full_info['project'] = ['id' => $project->id, 'title' => $project->title];

        $user = (new User())->find()->where(['id' => $this->user_create])->one();
        $this->full_info['user_created'] = ['id' => $user->id, 'username' => $user->username];

        $this->full_info['expressions'] = $events_model->getEventsExpressions();
        $this->full_info['events'] = $this->getEvents()->orderBy(['time_to_start' => 'ASC'])->all();
        $this->full_info['last_message'] = $this->getLastMessage();
        $this->full_info['observers'] = $this->getObservers();

        if (!empty($this->full_info['last_message'])) {
            $this->getCompareEvents();
        }

        return $this->full_info;
    }

    public function getObservers()
    {
        $resource = (new Query())->select('email')
                            ->from('triggers_observers')
                            ->where(['trigger_id' => $this->id])
                            ->orderBy(['email' => SORT_ASC])
                            ->all();
        $result = array();
        if (empty($resource)) {
            return $result;
        }

        foreach ($resource as $item) {
            $result[] = $item['email'];
        }

        return $result;
    }

    public function getLastMessage()
    {
        return (new Messages())->find()
                               ->where(['trigger_id' => $this->id])
                               ->orderBy(['created_date' => SORT_DESC])
                               ->limit(1)
                               ->one();
    }

    public function getCompareEvents()
    {
        if (empty($this->full_info)) {
            $this->_setFullTriggerInfo();
        }

        if (empty($this->full_info['last_message']) || empty($this->full_info['events'])) {
            return false;
        }

        $result = $this->full_info['last_message']['result_value'];

        foreach ($this->full_info['events'] as $key => $event) {
            if ($event['is_show'] == 1) {
                // Здесь находятся сравнения всех событий триггера с текущим полученным
                $this->full_info['events_results'][$event->id] = ($event->compare($result)) ? 'success' : 'error';
            }
        }
        return $this;
    }

    public function getTypeText()
    {
        $type = (new Query())->select('title')
                             ->from('triggers_types')
                             ->where(['id' => $this->trigger_type])
                             ->one();
        return $type['title'];
    }

    public function getImportanceSet()
    {
        $importance = (new Query())->select(['title', 'color'])
                             ->from('triggers_importance')
                             ->where(['id' => $this->importance])
                             ->one();
        return $importance;
    }

    public function run($event_id = null)
    {
        try {
            $connection = (new Databases)->find()->where(['id' => $this->db_id])->one()->getConnection();

            $result = $connection->createCommand($this->code)->queryScalar();
            $message = "Триггер <strong>{$this->title}</strong> выполнен. <br />Результат - <strong>{$result}</strong>";

            if ($event_id !== null) {

                $event_model = (new Events())->find()->where(['id' => $event_id])->one();
                $expression = $event_model->getExpression();

                if ($event_model->compare($result)) {
                    $message .= "<br />Ожидаемое значение: <span class='text-success'>{$expression['expression']} {$event_model->success_result}</span>";
                    $type = 'success';
                } else {
                    $message .= "<br />Ожидаемое значение: <span class='text-error'>{$expression['expression']} {$event_model->success_result}</span>";
                    $type = 'error';
                }
            } else {
                $type = 'normal';
            }

        } catch (\Exception $e) {
            $message = $e->getMessage();
            $type = 'system error';
        }

        $model = new Messages;
        $model->trigger_id = $this->id;
        $model->message = $message;
        $model->created_date = date('Y-m-d H:i:s');
        $model->result_value = $result;
        if ($event_id) {
            $model->event_id = $event_id;
        }
        $model->message_type = $type;
        $model->save();
        $model->sendMessages();
        return $model->message;
    }

    public function runEvent($event, $force = false)
    {
        $event_date = date('Y-m-d ' . $event->time_to_start) . PHP_EOL;
        $current_date = date('Y-m-d H:i:s');
        $last_message = $event->getLastMessage();

        if ($current_date > $event_date && $last_message['created_date'] < $event_date || $force) {
            $this->run($event->id);
        }

        return true;
    }

    public function runEventByEventId($event_id)
    {
        $event = (new Events())->find()->where(['id' => $event_id])->one();
        return $this->runEvent($event, true);
    }

    public function getTriggerMessages($trigger_id, $page)
    {
        $fields = [
            'messages.id',
            'message',
            'created_date',
            'message_type',
            'time_to_start',
            'success_result',
            'expression',
            'result_value'
        ];

        $query = (new Query())->select($fields)
                              ->from('messages')
                              ->join('LEFT JOIN', 'events', 'events.id = event_id')
                              ->join('LEFT JOIN', 'events_result_expressions', 'events_result_expressions.id = compare_exp')
                              ->where(['messages.trigger_id' => $trigger_id])
                              ->orderBy(['created_date' => SORT_DESC])
                              ->limit($this->_count_in_page)
                              ->offset(($page - 1) * $this->_count_in_page);
        return $query->all();
    }

    public function runChecked()
    {
        $events = $this->getEvents()->where(['is_show' => 1])->all();
        if (empty($events)) {
            return true;
        }

        foreach ($events as $event) {
            $this->runEvent($event);
        }

        return true;
    }

    public function addObserver($email)
    {
        $is_exist = (new Query())->select('email')
                              ->from('triggers_observers')
                              ->where(['trigger_id' => $this->id, 'email' => $email])
                              ->one();
        if ($is_exist) {
            return 'exist';
        }

        Yii::$app->db->createCommand()->insert('triggers_observers',['trigger_id' => $this->id, 'email' => $email])->execute();
        return 'ok';
    }

    public function deleteObserver($email)
    {
        return Yii::$app->db->createCommand()
                            ->delete('triggers_observers',['email' => $email, 'trigger_id' => $this->id])
                            ->execute();
    }

    public function getAlerts()
    {
        $triggers = $this->find()->all();
        $result = array();

        if (empty($triggers)) {
            return $result;
        }

        foreach ($triggers as $trigger) {
            $last_message = $trigger->getLastMessage();
            if (in_array($last_message->message_type, ['error', 'system error'])) {
                $result[$trigger->id]['trigger'] = $trigger;
                $result[$trigger->id]['last_message'] = $last_message;
            }
        }

        return $result;
    }

    static public function runBySchedule()
    {
        $triggers = (new Triggers())->find()->where(['is_active' => 1])->all();
        if (empty($triggers)) {
            return true;
        }

        foreach ($triggers as $trigger) {
            $trigger->runChecked();
        }

        return true;
    }

    static public function searchTriggers($query)
    {
        $result = (new self())->find()
                              ->where('title LIKE :query OR description LIKE :query or code LIKE :query', array(':query' => "%{$query}%"))
                              ->all();
        return $result;
    }
}

