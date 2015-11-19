<?php

namespace common\components\rbac;
use Yii;
use yii\rbac\Rule;
use yii\helpers\ArrayHelper;
use common\models\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
    public function execute($user, $item, $params)
    {
        //Получаем массив пользователя из базы
        $user = ArrayHelper::getValue($params, 'user', User::findOne($user));
        if ($user) {
            $role = $user->role; //Значение из поля role базы данных
            if ($item->name === 'manager') {
                return $role == User::ROLE_MANAGER;
            } elseif ($item->name === 'observer') {
                return $role == User::ROLE_MANAGER || $role == User::ROLE_OBSERVER;
            }
        }
        return false;
    }
}