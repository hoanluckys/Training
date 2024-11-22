<?php

namespace app\controllers;

use app\models\Project;

use app\models\ProjectStaff;
use app\models\User1;

use Yii;

use yii\data\Pagination;

use yii\filters\AccessControl;

use yii\data\ArrayDataProvider;

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
        $model = new Project();
        $currenUserId = Yii::$app->user->identity->id;
        if (Yii::$app->user->can('admin')){
            $query = Project::find()->with(['projectManager', 'projectstaff']);
        }
        else if (Yii::$app->user->can('projectManagement')){
            $query = Project::find()->where(['projectManagerId' => $currenUserId])->with(['projectManager', 'projectstaff']);
        }
        else {
            $query = Project::find()->joinWith('projectstaff')
            ->where(['projectstaff.userId' => $currenUserId])->with(['projectManager', 'projectstaff']);
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
        $projectManager = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'projectManagement'])->all();

        return $this->render('index',['alldata' => $all_data, 'model' => $model, 'staffs' => $staffs, 'projectManager' => $projectManager]);
    }

    public function actionView($id)
    {
        $model = Project::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }

    public function actionCreate()
    {
        $modelProject = new Project();
        $modelProjectStaff = new ProjectStaff();
        if ($modelProject->load(Yii::$app->request->post())) {
            $modelProject->load(Yii::$app->request->post());
            $modelProjectStaff->load(Yii::$app->request->post());
            if (Yii::$app->user->can('projectManagement')) {
                $modelProject->projectManagerId = Yii::$app->user->identity->id;
            }
            if ($modelProject->validate()) {
                if (Yii::$app->user->can('createProject')) {
                    if ($modelProject->save()) {
                        if ($modelProjectStaff->userId == !null) {
                            foreach ($modelProjectStaff->userId as $itemId) {
                                $newModelProjectStaff = new ProjectStaff();
                                $newModelProjectStaff->projectId = $modelProject->id;
                                $newModelProjectStaff->userId = $itemId;
                                $newModelProjectStaff->save();
                            }
                        }
                        Yii::$app->session->setFlash('success', 'Thêm dự án mới thành công.');
                    } else {
                        Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
                    }
                }
            } else {
                Yii::$app->session->setFlash('error', 'Thêm dự án mới thất bại.');
            }
            return $this->redirect(Yii::$app->request->referrer);
        }

        $staffs = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'staff'])->all();
        $projectManager = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'projectManagement'])->all();
        return $this->render('create', [
            'modelProject' => $modelProject,
            'modelProjectStaff' => $modelProjectStaff,
            'staffs' => $staffs,
            'projectManager' => $projectManager
        ]);

    }

    public function actionUpdate($id)
    {
        $modelProject = Project::findOne($id);
        $modelProjectStaff = new ProjectStaff();
        $modelProjectStaff->userId = \yii\helpers\ArrayHelper::getColumn(
            ProjectStaff::find()->where(['projectId' => $id])->all(),
            'userId'
        );

        if ($modelProject->load(Yii::$app->request->post())){
            if($modelProject->validate()){
                if($modelProject->save()){
                    $modelProjectStaff->load(Yii::$app->request->post());
                    if ($modelProjectStaff->userId == !null) {
                        foreach ($modelProjectStaff->userId as $itemId) {
                            if(!ProjectStaff::find()->where(['userId' => $itemId, 'projectId' => $id])->exists()) {
                                $newModelProjectStaff = new ProjectStaff();
                                $newModelProjectStaff->projectId = $modelProject->id;
                                $newModelProjectStaff->userId = $itemId;
                                $newModelProjectStaff->save();
                            }
                        }
                    }
                    Yii::$app->session->setFlash('success', 'Cập nhật dự án thành công.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
                else {
                    Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
        }

        $staffs = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'staff'])->all();
        $projectManager = User1::find()->innerJoin('auth_assignment','user.id = auth_assignment.user_id')->where(['auth_assignment.item_name' => 'projectManagement'])->all();
        return $this->render('update', [
            'modelProject' => $modelProject,
            'modelProjectStaff' => $modelProjectStaff,
            'staffs' => $staffs,
            'projectManager' => $projectManager,
        ]);
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
