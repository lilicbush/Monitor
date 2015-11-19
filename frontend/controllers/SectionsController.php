<?php

namespace frontend\controllers;

use common\models\Databases;
use common\models\Projects;
use common\models\Triggers;
use common\models\Sections;
use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;

class SectionsController extends RadarController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView()
    {
        $model = new Sections();
        $id = Yii::$app->getRequest()->get('id');
        $model = $model->find()->where(['id' => $id])->one();
        return Json::encode($model);
    }

    public function actionInfo()
    {
        $section_model = new Sections();
        $project_model = new Projects();
        $trigger_model = new Triggers();
        $database_model = new Databases();

        $id = Yii::$app->getRequest()->get('id');
        $result = array();

        $result['section'] = $section_model->find()->where(['id' => $id])->one();
        $result['project'] = $project_model->find()->where(['id' => $result['section']->project_id])->one();
        $result['importance_items'] = $trigger_model->getImportanceItems();
        $result['trigger_types'] = $trigger_model->getTypes();
        $result['databases'] = $database_model->getDatabases();

        return Json::encode($result);
    }

    public function actionTriggers()
    {
        $model = new Sections();
        $id = Yii::$app->getRequest()->get('id');
        $model = $model->getSectionWithTriggers($id);
        return Json::encode($model);
    }

    public function actionCreate()
    {
        $model = new Sections;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->attributes = $post['section'];
            if($model->save()) {
                $this->redirect(array('view','id' => $model->id));
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = new Sections;

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model = $model->find()->where(['id' => $id])->one();
            $model->attributes = $post['section'];
            $model->save();
        } else {
            $model = $model->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        $model = new Sections;
        $model->find()->where(['id' => $id])->one()->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionList()
    {
        $model = new Sections;
        $items = $model->getSectionsWithProjects();
        return Json::encode($items);
    }
}