<?php

namespace console\controllers;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\Triggers;
use common\models\Events;
use common\models\Messages;

class CheckController extends Controller
{
    public function actionRun()
    {
        $this->stdout("Сканирование систем запущено\n", Console::FG_YELLOW);
        Triggers::runBySchedule();
        $this->stdout("Сканирование систем завершено\n", Console::FG_GREEN);
        return 1;
    }
}