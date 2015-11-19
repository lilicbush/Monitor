<?php

namespace console\controllers;
use common\models\Settings;
use yii\console\Controller;
use yii\helpers\Console;
use common\models\User;

class InstallController extends Controller
{
    public function actionStart($user, $email, $password)
    {
        $this->stdout("Инициализация стартового пользователя \n", Console::FG_YELLOW);

        $model = new User;
        $model->username = $user;
        $model->email = $email;

        $model->setPassword($password);
        $model->generateAuthKey();

        if ($model->save()) {
            $this->stdout("Инициализирован стартовый пользователь\n", Console::FG_YELLOW);
            $message = "Внимание!\n После инициализации стартового пользователя и настройки сайта данный скрипт необходимо удалить или закоментировать\n";
            $this->stdout($message, Console::FG_RED);
            return '';
        }

        return 1;
    }

    public function actionSetup($from_email, $domain)
    {
        $this->stdout("Настройка системы \n", Console::FG_YELLOW);

        $model = new Settings;
        $model->name = 'from_email';
        $model->value = $from_email;
        $model->save();

        $model = new Settings;
        $model->name = 'domain';
        $model->value = $domain;
        $model->save();

        $this->stdout("Настройка системы завершена \n", Console::FG_YELLOW);
        return 1;
    }
}