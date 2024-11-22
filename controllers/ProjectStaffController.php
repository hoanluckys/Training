<?php

namespace app\controllers;

use app\models\Project;
use app\models\ProjectStaff;
use app\models\User1;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use Yii;

class ProjectStaffController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Bạn không có quyền truy cập vào chức năng này.');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['projectManagement'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['staff'],
                        'actions' => ['index'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $model = new ProjectStaff();
        $currentUserId = Yii::$app->user->identity->id;
        if (Yii::$app->user->can('admin')){
            $query = ProjectStaff::find()->with(['project','user']);
            $all_project = Project::find()->with(['projectManager','projectstaff'])->all();
        }
        else if (Yii::$app->user->can('projectManagement')){
//            $query = ProjectStaff::find()->where(['projectId' => $currenUserId])->with(['project','user']);
            $query = ProjectStaff::find()
                ->joinWith('project')  // Kết nối với bảng Project
                ->where(['project.projectManagerId' => $currentUserId])
                ->with(['project','user']);
            $all_project = Project::find()->with(['projectManager','projectstaff'])->where(['projectManagerId' => $currentUserId])->all();
        }
        else{
            $query = ProjectStaff::find()->where(['userID' => $currentUserId])->with(['project','user']);
            $all_project = [];
        }
        $count = $query->count();

        $all_data = $query->all();
        $all_data = new ArrayDataProvider([
            'allModels' => $all_data,
            'pagination' => [
                'pageSize' => 15,
            ],
        ]);

        $staffs = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'staff'])->all();
        return $this->render('index',['alldata' => $all_data, 'model' => $model, 'staffs' => $staffs, 'all_project' => $all_project]);
    }

    public function actionView($id)
    {
        return "view";
    }

    public function actionCreate()
    {
        $model = new ProjectStaff();
        $model->load(Yii::$app->request->post());
        $check = ProjectStaff::find()->where(['projectId' => $model->projectId, 'userId' => $model->userId])->count();
        if ($check >0 ){
            Yii::$app->session->setFlash('error', 'Đã tồn tại nhân viên trong dự án.');
            return $this->redirect(Yii::$app->request->referrer);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Thêm nhân viên mới thành công.');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $model = ProjectStaff::findOne($id);
        if($model->delete()){
            Yii::$app->session->setFlash('success', 'Xóa dự án thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa dự án thất bại.');
        }
    }

}
