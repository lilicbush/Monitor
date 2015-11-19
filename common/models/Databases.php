<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\db\Connection;

/**
 * This is the model class for table "databases".
 *
 * @property integer $id
 * @property string $dsn
 * @property string $dbname
 * @property integer $dbms_id
 * @property string $username
 * @property string $password
 * @property string $title
 *
 * @property Dbms $dbms
 * @property Triggers[] $triggers
 */
class Databases extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'databases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dsn', 'dbname', 'dbms_id', 'username', 'password', 'title'], 'required'],
            [['dbms_id'], 'integer'],
            [['title'], 'string'],
            [['dsn', 'dbname', 'username', 'password', 'title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dsn' => 'Dsn',
            'dbname' => 'Dbname',
            'dbms_id' => 'Dbms ID',
            'username' => 'Username',
            'password' => 'Password',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDbms()
    {
        return $this->hasOne(Dbms::className(), ['id' => 'dbms_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTriggers()
    {
        return $this->hasMany(Triggers::className(), ['db_id' => 'id']);
    }


    public function getDatabases()
    {
        return $this->find()->with('dbms')->asArray()->all();
    }

    public function getDbmsList()
    {
        $list = (new Query())->select(['id', 'name'])
                             ->from('dbms')
                             ->orderBy(['name' => 'ASC'])
                             ->all();
        return $list;
    }

    public function getConnection()
    {
        return new Connection([
            'dsn' => $this->dsn,
            'username' => $this->username,
            'password' => $this->password
        ]);
    }
}
