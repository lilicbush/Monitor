<?php
namespace frontend\components;
use yii\web\Controller;

class RadarController extends Controller
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionTemplate($src)
    {
        echo $this->renderPartial($src, array(), false, true);
    }
}
