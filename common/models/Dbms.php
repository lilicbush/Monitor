<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dbms".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Databases[] $databases
 */
class Dbms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dbms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatabases()
    {
        return $this->hasMany(Databases::className(), ['dbms_id' => 'id']);
    }
}
