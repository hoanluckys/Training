<?php

namespace app\controllers;

use app\models\Project;

use app\models\User1;
use Yii;

use yii\data\Pagination;
use yii\filters\AccessControl;

class ProjectController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => function ($rule, $action) {
                    throw new \yii\web\ForbiddenHttpException('Bạn không có quyền truy cập vào chức năng này.');
                },
//                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['projectManagement'],
                    ],
//                    [
//                        'allow' => true,
//                        'roles' => ['staff'],
//                        'actions' => ['index'],
//                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {
        $model = new Project();
        $currenUserId = Yii::$app->user->identity->id;
        if (Yii::$app->user->can('admin')){
            $query = Project::find()->with('projectManager');
        }
        else{
            $query = Project::find()->where(['projectManagerId' => $currenUserId])->with('projectManager');
        }
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $staffs = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'staff'])->all();
        $projectManager = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'projectManagement'])->all();

        return $this->render('index',['alldata' => $all_data, 'pagination' => $pagination, 'model' => $model, 'staffs' => $staffs, 'projectManager' => $projectManager]);
    }

    public function actionView($id)
    {
        $model = Project::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }

    public function actionCreate()
    {
        $model = new Project();
        $model->load(Yii::$app->request->post());
        if (Yii::$app->user->can('projectManagement')){
            $model->projectManagerId = Yii::$app->user->identity->id;
        }
        if($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Yii::$app->user->can('createProject')) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Thêm dự án mới thành công.');
                } else {
                    Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
                }
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate($id)
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

    public function actionDelete($id)
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
