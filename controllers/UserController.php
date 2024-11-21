<?php

namespace app\controllers;

use app\models\Project;
use app\models\User1;

use yii\data\Pagination;

use Yii;

use yii\filters\AccessControl;

use yii\web\Controller;


class UserController extends Controller
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
                        'actions' => ['profile', 'update-profile', 'change-password'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['staff'],
                        'actions' => ['profile', 'update-profile', 'change-password'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'actions' => ['create'],
                    ],
                ],
            ],
        ];
    }



    /**
     * @return string
     */
    public function actionIndex()
    {
        $model = new User1();
        $query = User1::find();
        $count = $query->count();
        $pagination = new Pagination(['defaultPageSize' => 2, 'totalCount' => $count]);
        $all_data = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['alldata' => $all_data, 'pagination' => $pagination, 'model' => $model]);
    }

    /**
     * @param $id
     * @return array
     */

    public function actionView($id)
    {
        $model = User1::findOne($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $model->toArray();
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $model = new User1();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $password_ = $model->password;
            $model->password = md5($password_);
            if($model->save()){
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($model->role);
                $auth->assign($role, $model->id);
//                Yii::$app->session->setFlash('success', Yii::t('vi', 'create') );
                Yii::$app->session->setFlash('success', 'Tạo tài khoản mới thành công.');
                return $this->redirect(Yii::$app->request->referrer);
            }
            else{
                Yii::$app->session->setFlash('error', 'Tạo tài khoản mới thất bại.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        else {
            Yii::$app->session->setFlash('error', 'Tạo tài khoản mới thất bại.');
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    public function actionUpdate($id)
    {
        $model = User1::findOne($id);
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            if($model->save()){
                $auth = Yii::$app->authManager;
                $auth->revokeAll($model->id);
                $role = $auth->getRole($model->role);
                $auth->assign($role, $model->id);
                Yii::$app->session->setFlash('success', 'Cập nhật thành công.');
                return $this->redirect(Yii::$app->request->referrer);
            }
            else {
                Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        return "edit";
    }

    /**
     * @param $id
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        if ($id == Yii::$app->user->identity->id) Yii::$app->session->setFlash('success', 'Không thể xóa chính mình.');
        $model = User1::findOne($id);
        if($model->delete()){
            $auth = Yii::$app->authManager;
            $auth->revokeAll($id);
            Yii::$app->session->setFlash('success', 'Xóa người dùng thành công.');
        }
        else {
            Yii::$app->session->setFlash('error', 'Xóa người dùng thất bại.');
        }
    }

    public function actionProfile()
    {
        return $this->render('info');
    }

    public function actionUpdateProfile()
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
        Yii::$app->session->setFlash('error', 'Cập nhật thất bại.');
        return $this->redirect(Yii::$app->request->referrer);
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
        return Yii::$app->response->redirect(['user/profile']);
    }

    public function actionStatistical()
    {
        $dataListUserDb = User1::find()->where(['role' => 'projectManagement'])->all();
        $dataCountProject = [];
        $dataListUser = [];
        foreach ($dataListUserDb as $item) {
            $dataListUser[] = $item->username;
            $dataCountProject[] = Project::find()->where(['projectManagerId' => $item->id])->count();
        }
        return $this->render('statistical', ['dataListUser' => $dataListUser, 'dataCountProject' => $dataCountProject]);
    }

}
