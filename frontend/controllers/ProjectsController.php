<?php
namespace frontend\controllers;

use Yii;
use frontend\components\RadarController;
use common\models\Projects;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class ProjectsController extends RadarController
{
    private $_upload_path ;

    public function init()
    {
        $this->_upload_path = Yii::getAlias('@webroot/upload');
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionTree()
    {
        $model = new Projects();
        return $model->getProjectsTreeJSON();
    }

    public function actionView()
    {
        $model = new Projects;
        $id = Yii::$app->getRequest()->get('id');
        $model = $model->getProjectWithSections($id);
        return Json::encode($model);
    }

    public function actionCreate()
    {
        $model = new Projects;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->attributes = $post['project'];
            if($model->save()) {
                $this->redirect(array('view','id' => $model->id));
            } else {
                print_r($model->getErrors());
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = new Projects;

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model = $model->find()->where(['id' => $id])->one();
            $model->attributes = $post['project'];
            $model->save();
        } else {
            $model = $model->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        $model = new Projects;
        $model->find()->where(['id' => $id])->one()->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionUpload()
    {
        $file = UploadedFile::getInstanceByName('Files');
        $filename = md5(microtime()) . '.' . $file->extension;

        if (!$this->_prepareDirs()) {
            Json::encode(array('error' => 1));
        };

        $logos_path = $this->_upload_path . '/logos/';
        $file->saveAs($logos_path . $filename);
        echo Json::encode(array('filename' => $filename));
    }

    public function actionDeletelogo($id)
    {
        $model = new Projects;
        $model = $model->find()->where(['id' => $id])->one();
        $error = ($model->deleteLogo()) ? 0 : 1;

        return Json::encode(array($error => 1));
    }

    private function _prepareDirs()
    {
        try {

            if (!is_dir($this->_upload_path)) {
                mkdir($this->_upload_path, 0777);
            }

            $logos_path = $this->_upload_path . '/logos';

            if (!is_dir($logos_path)) {
                mkdir($logos_path, 0777);
            }

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function actionList()
    {
        $model = new Projects;
        return Json::encode($model->find()->all());
    }

    public function actionSchedule()
    {
        $model = new Projects;
        return Json::encode($model->getSchedule());
    }
}
