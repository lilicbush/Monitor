<?php

namespace common\models;

use Yii;
use \yii\db\Query;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "events".
 *
 * @property integer $id
 * @property integer $trigger_id
 * @property string $time_to_start
 * @property integer $is_show
 * @property string $success_result
 * @property integer $compare_exp
 *
 * @property EventsResultExpressions $compareExp
 * @property Triggers $trigger
 * @property Messages[] $messages
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['trigger_id'], 'required'],
            [['trigger_id', 'is_show', 'compare_exp'], 'integer'],
            [['time_to_start'], 'safe'],
            [['success_result'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trigger_id' => 'Trigger ID',
            'time_to_start' => 'Time To Start',
            'is_show' => 'Is Show',
            'success_result' => 'Success Result',
            'compare_exp' => 'Compare Exp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompareExp()
    {
        return $this->hasOne(EventsResultExpressions::className(), ['id' => 'compare_exp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrigger()
    {
        return $this->hasOne(Triggers::className(), ['id' => 'trigger_id']);
    }

    public function getEventsExpressions()
    {
        $resource = (new Query())->select(['id', 'expression'])
                            ->from('events_result_expressions')
                            ->all();
        $result = array();
        foreach ($resource as $item) {
            $result[$item['id']] = $item;
        }

        return $result;
    }

    public function getExpression()
    {
        $resource = (new Query())->select(['expression'])
                                 ->from('events_result_expressions')
                                 ->where(['id' => $this->compare_exp])
                                 ->one();
        return $resource;
    }

    public function compare($result)
    {
        switch ($this->compare_exp) {
            case '1':
                return $result > $this->success_result;
                break;
            case '2':
                return $result >= $this->success_result;
                break;
            case '3':
                return $result < $this->success_result;
                break;
            case '4':
                return $result <= $this->success_result;
                break;
            case '5':
                return $result == $this->success_result;
                break;
            case '6':
                return $result != $this->success_result;
                break;
        }

        return false;
    }

    public function getLastMessage()
    {
        return (new Messages())->find()->where(['event_id' => $this->id])->orderBy(['created_date' => SORT_DESC])->one();
    }

    public function run()
    {
        return (new Triggers())->find()->where(['id' => $this->trigger_id])->one()->runEvent($this, true);
    }

}
