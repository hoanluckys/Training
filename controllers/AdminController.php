<?php

namespace app\controllers;

use app\models\User1;

use app\models\Project;

use yii\data\Pagination;

use Yii;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin';

    public function  actionViewoneuser($id)
    {
        $model = User1::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }
    public function actionViewusers()
    {
        $query = User1::find();
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('@app/views/page/user',['alldata' => $all_data, 'pagination' => $pagination]);
    }

    public function actionAdduser()
    {
        $model = new User1();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $password_ = $model->password;
            $model->password = md5($password_);
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Thêm người dùng mới thành công.');
                return $this->redirect(Yii::$app->request->referrer);
            }
            else{
                Yii::$app->session->setFlash('error', 'Thêm người dùng mới thất bại.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Thêm người dùng mới thất bại.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionEdituser($id)
    {
        $model = User1::findOne($id);
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Cập nhật người dùng thành công.');
                return $this->redirect(Yii::$app->request->referrer);
            }
            else {
                Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return "edit";
    }

    public function actionDeleteuser($id)
    {
        $model = User1::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Xóa người dùng thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa người dùng thất bại.');
        }
    }

    public function actionViewproject()
    {
        $query = Project::find()->with('projectManager');;
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('@app/views/page/project',['alldata' => $all_data, 'pagination' => $pagination]);
    }

    public function actionAddproject()
    {
        $model = new Project();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->save()){
                Yii::$app->session->setFlash('success', 'Thêm dự án mới thành công.');
            }
            else{
                Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionViewoneproject($id)
    {
        $model = Project::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }

    public function actionEditproject($id)
    {
        $model = Project::findOne($id);
        if (Yii::$app->request->isPatch){
            if($model->load(Yii::$app->request->post()) && $model->validate()){
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Cập nhật dự án thành công.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                else {
                    Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }
        return "edit";
    }

    public function actionDeleteproject($id)
    {
        $model = Project::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Xóa dự án thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa dự án thất bại.');
        }
    }

}
