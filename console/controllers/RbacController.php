<?php

namespace console\controllers;
use Yii;
use yii\console\Controller;
use common\components\rbac\UserRoleRule;


class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
        $dashboard = $auth->createPermission('dashboard');
        $dashboard->description = 'Главная панель радара';
        $auth->add($dashboard);
        $rule = new UserRoleRule();
        $auth->add($rule);

        $observer = $auth->createRole('observer');
        $observer->description = 'Наблюдатель';
        $observer->ruleName = $rule->name;
        $auth->add($observer);

        $manager = $auth->createRole('manager');
        $manager->description = 'Управляющий';
        $manager->ruleName = $rule->name;
        $auth->add($manager);

        $auth->addChild($manager, $observer);
        $auth->addChild($manager, $dashboard);
    }
}