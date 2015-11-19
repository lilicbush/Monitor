<?php

namespace frontend\controllers;

use common\models\Messages;
use common\models\Triggers;
use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;
use yii\helpers\VarDumper;

class TriggersController extends RadarController
{
    public function actionCreate()
    {
        $model = new Triggers;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->attributes = $post['trigger'];
            $model->user_create = Yii::$app->user->getId();
            if(!$model->save()) {
                VarDumper::dump($model->getErrors(), 10, 1);
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = new Triggers;

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model = $this->getModel($id);
            $model->attributes = $post['trigger'];
            $model->save();
        } else {
            $model = $model->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        $model = $this->getModel($id)->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionView($id)
    {
        $model = $this->getModel($id);
        return Json::encode($model);
    }

    public function actionFull($id)
    {
        $model = $this->getModel($id);
        return Json::encode(['trigger' => $model, 'trigger_info' => $model->getFullTriggerInfo()]);
    }

    public function actionActivity($id)
    {
        $model = $this->getModel($id);
        $post = Json::decode(file_get_contents('php://input'));
        $model->is_active = $post['activity'];
        return $model->save();
    }

    public function actionRun($id)
    {
        return $this->getModel($id)->run();
    }

    public function actionMessages($id, $page = 1)
    {
        $model = $this->getModel($id);
        return Json::encode($model->getTriggerMessages($id, $page));
    }

    public function actionAddobserver()
    {
        if ($post = Json::decode(file_get_contents('php://input'))) {
            $model = (new Triggers())->find()->where(['id' => $post['id']])->one();
            return $model->addObserver($post['observer']);
        }

        return 'error';
    }

    public function actionDeleteobserver()
    {
        if ($post = Json::decode(file_get_contents('php://input'))) {
            $model = (new Triggers())->find()->where(['id' => $post['id']])->one();
            return $model->deleteObserver($post['observer']);
        }

        return 'error';
    }

    public function getModel($id)
    {
        return (new Triggers)->find()->where(['id' => $id])->one();
    }

    public function actionAlerts()
    {
        $model = new Triggers();
        return Json::encode(array_values($model->getAlerts()));
    }
}