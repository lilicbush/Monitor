<?php

namespace common\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "messages".
 *
 * @property integer $id
 * @property string $message
 * @property integer $trigger_id
 * @property string $created_date
 * @property integer $event_id
 * @property string $message_type
 * @property string $result_value
 *
 * @property Events $event
 * @property Triggers $trigger
 */
class Messages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message', 'result_value'], 'string'],
            [['trigger_id', 'event_id'], 'integer'],
            [['trigger_id'], 'required'],
            [['created_date'], 'safe'],
            [['message_type'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Message',
            'trigger_id' => 'Trigger ID',
            'created_date' => 'Created Date',
            'event_id' => 'Event ID',
            'message_type' => 'Message Type',
            'result_value' => 'Result Value',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(Events::className(), ['id' => 'event_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrigger()
    {
        return $this->hasOne(Triggers::className(), ['id' => 'trigger_id']);
    }

    public function sendMessages()
    {
        if (!in_array($this->message_type, ['error', 'system error'])) {
            return false;
        }

        $model = (new Triggers())->find()->where(['id' => $this->trigger_id])->one();
        $observers = $model->getObservers();

        $domain = Settings::get('domain');

        $message = "Триггер мониторинга
                    {$model->title}
                    сообщил, что текущее состояние базы данных отлично от нормы.
                    <br />Текст сообщения:<br />
                    {$this->message}<br />
                    Подробности на
                    <a href='http://{$domain}/#/triggers/view/{$this->trigger_id}'>
                        странице триггера
                    </a>";

        foreach ($observers as $observer) {
            Yii::$app->mailer->compose()
                             ->setFrom(Settings::get('from_email'))
                             ->setTo($observer)
                             ->setSubject('Новое сообщение триггера мониторинга ' . $model->title)
                             ->setHtmlBody($message)
                             ->send();
        }

        return true;
    }

}