<?php

namespace app\controllers;
use Yii;
use app\models\User1;

class AuthController extends \yii\web\Controller
{
    public function actionLoginget()
    {
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(['admin/user']);
        }
        return $this->render('@app/views/page/login');
    }

    public function actionWeb()
    {
        return Yii::$app->response->redirect(['/login']);
    }

    public function actionLoginpost()
    {
        $model = new User1();
        if ($model->load(Yii::$app->request->post())) {
            $user = User1::findByUsername($model->username);
            if ($user && $user->validatePassword(md5($model->password))) {
                Yii::$app->user->login($user);
                return Yii::$app->response->redirect(['admin/user']);
            } else {
                Yii::$app->session->setFlash('error', 'Thông tin đăng nhập không chính xác.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return "Fail";
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return Yii::$app->response->redirect(['auth/loginget']);
    }

    public function actionViewinfo(){
        return $this->render('@app/views/page/info');
    }

    public function actionEditinfo()
    {
        $id = Yii::$app->user->identity->id;
        $model = User1::findOne($id);
        if (Yii::$app->request->isPatch){
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Cập nhật thông tin thành công.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                else {
                    Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }
        return "edit info";
    }

    public function actionChangepassword()
    {
        $model = Yii::$app->user->identity;
        if (Yii::$app->request->post()) {
            $oldPassword = Yii::$app->request->post('oldPassword');
            $newPassword = Yii::$app->request->post('newPassword');
        }
        return "change password";
    }

}
