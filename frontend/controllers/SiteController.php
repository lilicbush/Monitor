<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use frontend\components\RadarController;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends RadarController
{
    public function actionIndex()
    {
        return $this->render('empty');
    }

    public function actionAlert()
    {
        return $this->render('alert');
    }
}
