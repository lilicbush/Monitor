<?php

namespace frontend\controllers;

use common\models\Databases;
use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\db\Connection;
use common\models\Settings;

class DatabasesController extends RadarController
{
    public function actionCreate()
    {
        $model = new Databases;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->attributes = $post['database'];
            if(!$model->save()) {
                VarDumper::dump($model->getErrors(), 10, 1);
            }
        }
    }

    public function actionUpdate($id)
    {
        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model = (new Databases)->find()->where(['id' => $id])->one();
            $model->attributes = $post['database'];
            $model->save();
        } else {
            $model = (new Databases)->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        (new Databases)->find()->where(['id' => $id])->one()->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionView($id)
    {
        $model = (new Databases)->find()->where(['id' => $id])->with()->one();
        return Json::encode($model);
    }

    public function actionInfo($id)
    {
        $model = (new Databases)->find()->where(['id' => $id])->one();
        return Json::encode($model);
    }

    public function actionList()
    {
        $list = (new Databases)->find()->with('dbms')->orderBy('title')->all();
        return Json::encode($list);
    }

    public function actionDbms()
    {
        $dbms = (new Databases())->getDbmsList();
        return Json::encode($dbms);
    }

    public function actionTest()
    {
        if ($post = Json::decode(file_get_contents('php://input'))) {
            $database = $post['database'];
            $params = [
                'dsn' => $database['dsn'],
                'username' => $database['username'],
                'password' => $database['password']
            ];

            try {
                $connection = new Connection($params);
                $connection->open();
                return Json::encode(['result' => 'success']);
            } catch (\Exception $e) {
                return Json::encode(['result' => 'error', 'error' => $e->getMessage()]);
            }
        }
    }
}