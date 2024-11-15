<?php

namespace app\controllers;
use Yii;
use app\models\User1;

class AuthController extends \yii\web\Controller
{
    public function actionLoginget()
    {
        if (!Yii::$app->user->isGuest) {
            return "Bạn đã đăng nhập rồi.";
        }
        return $this->render('@app/views/page/login');
    }

    public function actionLoginpost()
    {
        $model = new User1();
        if ($model->load(Yii::$app->request->post())) {
            $user = User1::findByUsername($model->username);
            if ($user && $user->validatePassword($model->password)) {
                Yii::$app->user->login($user);
                return "Success";
            } else {
                Yii::$app->session->setFlash('error', 'Thông tin đăng nhập không chính xác.');
                return "Thông tin đăng nhập không chính xác.";
            }
        }

        return "Fail";
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return "Logout Success";
    }

}
