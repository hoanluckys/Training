<?php

namespace app\controllers;

use app\models\User1;

use app\models\Project;

use yii\data\Pagination;

use Yii;

use yii\filters\AccessControl;

class AdminController extends \yii\web\Controller
{
    public $layout = 'admin';

//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::class,
////                'only' => ['create', 'update', 'delete'],
//                'rules' => [
//                    [
//                        'allow' => true,
//                        'roles' => ['admin'],
////                        'actions' => ['view-project']
//                    ],
//                    [
//                        'allow' => true,
//                        'roles' => ['projectManagement'],
//                    ],
//                    [
//                        'allow' => true,
//                        'roles' => ['staff'],
////                        'actions' => ['add-userh'],
//                    ],
//                ],
//            ],
//        ];
//    }

    public function  actionViewOneUser($id)
    {
        $model = User1::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }
    public function actionViewUsers()
    {
        $query = User1::find();
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('user',['alldata' => $all_data, 'pagination' => $pagination]);
    }

    public function actionAddUser()
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

    public function actionEditUser($id)
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

    public function actionDeleteUser($id)
    {
        $model = User1::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Xóa người dùng thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa người dùng thất bại.');
        }
    }

    public function actionViewProject()
    {
        $query = Project::find()->with('projectManager');;
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('project',['alldata' => $all_data, 'pagination' => $pagination]);
    }

    public function actionAddProject()
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

    public function actionViewOneProject($id)
    {
        $model = Project::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }

    public function actionEditProject($id)
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

    public function actionDeleteProject($id)
    {
        $model = Project::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Xóa dự án thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa dự án thất bại.');
        }
    }

    public function actionViewStatistical()
    {
        return $this->render('statistical');
    }

}
