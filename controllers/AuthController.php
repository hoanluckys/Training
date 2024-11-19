<?php

namespace app\controllers;
use Yii;
use app\models\User1;
use yii\helpers\VarDumper;

class AuthController extends \yii\web\Controller
{
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->response->redirect(['admin/view-users']);
        }
        return $this->render('login');
    }

    public function actionWeb()
    {
        return Yii::$app->response->redirect(['auth/login']);
    }

    public function actionLoginpost()
    {
        $model = new User1();
        if ($model->load(Yii::$app->request->post())) {
            $user = User1::findByUsername($model->username);
            if ($user && $user->validatePassword(md5($model->password))) {
                Yii::$app->user->login($user);
                return Yii::$app->response->redirect(['admin/view-users']);
            } else {
                Yii::$app->session->setFlash('error', 'Thông tin đăng nhập không chính xác. <a href="forgetpassword">Quên mật khẩu</a>');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        return "Fail";
    }

    public function actionLogoutAccount()
    {
        Yii::$app->user->logout();
        return Yii::$app->response->redirect(['auth/login']);
    }

    public function actionInfo(){
        return $this->render('info');
    }

    public function actionEditInfo()
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

    public function actionChangePassword()
    {
        if (Yii::$app->request->isPatch) {
            $model = Yii::$app->user->identity;
            if (Yii::$app->request->post()) {
                $oldPassword = Yii::$app->request->post('DynamicModel')['oldPassword'];
                $newPassword1 = Yii::$app->request->post('DynamicModel')['newPassword1'];
                $newPassword2 = Yii::$app->request->post('DynamicModel')['newPassword2'];
                if ($newPassword1 == $newPassword2) {
                    if (md5($oldPassword) == $model->password) {
                        $model->password = md5($newPassword1);
                        $model->save();
                        Yii::$app->session->setFlash('success', 'Đổi mật khẩu thành công.');
                    }
                    else {
                        Yii::$app->session->setFlash('error', 'Mật khẩu cũ không chính xác.');
                    }
                }
                else {
                    Yii::$app->session->setFlash('error', 'Mật khẩu mới không trùng khớp.');
                }
            }
        }
        return Yii::$app->response->redirect(['auth/info']);
    }


}


