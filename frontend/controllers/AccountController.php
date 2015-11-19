<?php

namespace frontend\controllers;

use Yii;
use frontend\components\RadarController;
use yii\helpers\Json;
use common\models\LoginForm;
use common\models\User;

class AccountController extends RadarController
{
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $post = Json::decode(file_get_contents('php://input'));
        $model->username = $post['user']['login'];
        $model->password = $post['user']['password'];
        $model->rememberMe = true;
        return ($model->login()) ? 'ok' : 'error';
    }

    public function actionRole()
    {
        if (Yii::$app->user->isGuest) {
            return 'guest';
        }

        return Yii::$app->user->getIdentity()->role;
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return 'ok';
    }

    public function actionPassword()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $old_password = $post['old'];
            $new_password = $post['new'];

            $model = (new User())->find()->where(['id' => Yii::$app->user->getId()])->one();

            if ($model->validatePassword($old_password)) {
                $model->setPassword($new_password);
                $model->save();
                return 'ok';
            } else {
                return 'wrong_password';
            }
        }

        return false;
    }

    public function actionList()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        $users = (new User)->find()->orderBy(['username' => 'ASC'])->all();
        return Json::encode($users);
    }

    public function actionCreate()
    {
        $model = new User;

        if ($post = Json::decode(file_get_contents('php://input')))
        {
            $model->username = $post['user']['username'];
            $model->email = $post['user']['email'];

            if ($post['user']['password']) {
                $model->setPassword($post['user']['password']);
            }
            $model->generateAuthKey();
            if ($model->save()) {
                return 'ok';
            }
        }
    }

    public function actionUpdate($id)
    {
        $model = (new User)->find()->where(['id' => $id])->one();

        if($post = Json::decode(file_get_contents('php://input')))
        {
            $model->username = $post['user']['username'];
            $model->email = $post['user']['email'];

            if ($post['user']['password']) {
                $model->setPassword($post['user']['password']);
            }
            $model->generateAuthKey();
            if ($model->save()) {
                return 'ok';
            }
        } else {
            $model = $model->find()->where(['id' => $id])->asArray()->one();
            return Json::encode($model);
        }
    }

    public function actionDelete($id)
    {
        $model = new User;
        $model->find()->where(['id' => $id])->one()->delete();
        return Json::encode(array('error' => 0));
    }

    public function actionInfo($id)
    {
        $model = (new User)->find()->where(['id' => $id])->one();
        return Json::encode($model);
    }

}