<?php

namespace frontend\controllers;

use common\models\Events;
use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class EventsController extends RadarController
{
    public function actionCreate()
    {
        $model = new Events;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->attributes = $post['event'];
            $model->time_to_start = date('H:i:s', strtotime($model->time_to_start));
            if(!$model->save()) {
                VarDumper::dump($model->getErrors(), 10, 1);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = new Events;

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model = $model->find()->where(['id' => $id])->one();
            $model->attributes = $post['event'];
            $model->time_to_start = date('H:i:s', strtotime($model->time_to_start));
            $model->save();
            return 'ok';
        } else {
            $model = $model->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        $model = new Events;
        $model->find()->where(['id' => $id])->one()->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionInfo($id)
    {
        $model = new Events;
        $model = $model->find()->where(['id' => $id])->with()->one();
        return Json::encode($model);
    }

    public function actionActivity($id)
    {
        $model = (new Events)->find()->where(['id' => $id])->one();
        $post = Json::decode(file_get_contents('php://input'));
        $model->is_show = $post['activity'];
        return $model->save();
    }

    public function actionRun($id)
    {
        return (new Events)->find()->where(['id' => $id])->one()->run($id);
    }
}