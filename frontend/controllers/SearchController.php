<?php

namespace frontend\controllers;
use common\models\Projects;
use common\models\Sections;
use common\models\Triggers;
use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;

class SearchController extends RadarController
{
    public function actionList()
    {
        if ($post = Json::decode(file_get_contents('php://input'))) {
            $query = $post['search'];
            $result = array();
            $result['projects'] = Projects::searchProjects($query);
            $result['sections'] = Sections::searchSections($query);
            $result['triggers'] = Triggers::searchTriggers($query);

            return Json::encode($result);
        }
    }
}