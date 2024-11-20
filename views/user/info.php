<?php
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\User1;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use app\widgets\Alert;
?>


<?php
$this->title = 'Thông tin cá nhân';
$this->params['breadcrumbs'][] = $this->title;

$info_user = Yii::$app->user->identity;

$model = new User1();
$form = ActiveForm::begin([
    'id' =>  'formUser',
    'action' => ['user/update-profile'],
    'method' => 'post',
]);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa thông tin cá nhân</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'username')->textInput(['id' => 'username', 'placeholder' => 'Tên người dùng...']) ?>
                <?= $form->field($model, 'name')->textInput(['id' => 'name', 'placeholder' => 'Họ và tên...']) ?>
                <?= $form->field($model, 'email')->textInput(['id' => 'email', 'placeholder' => 'Email...']) ?>
                <?= $form->field($model, 'password')->textInput(['id' => 'password', 'placeholder' => 'Mật khẩu...']) ?>

                <?= $form->field($model, 'role')->dropDownList(
                    [
                        'staff' => 'User',
                        'admin' => 'Administrator',
                        'projectManagement' => 'Project Management',
                    ],
                    ['id' => 'role', 'disabled' => true]
                ) ?>

                <?= $form->field($model, 'description')->textarea(['id' => 'description', 'placeholder' => 'Mô tả...']) ?>
                <?= Html::hiddenInput('_method', 'PATCH', ['id' => '_method']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?=  Html::submitButton('Lưu', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php

$formModel = new \yii\base\DynamicModel(['oldPassword', 'newPassword1', 'newPassword2']);

$form2 = ActiveForm::begin([
    'id' =>  'formPassword',
    'action' => ['user/change-password'],
    'method' => 'PATCH',
]);
?>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đổi mật khẩu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($formModel, 'oldPassword')->passwordInput(['id' => 'oldpassword', 'placeholder' => 'Mật khẩu hiện tại...'])->label("Mật khẩu cũ") ?>
                <?= $form->field($formModel, 'newPassword1')->passwordInput(['id' => 'newPassword1', 'placeholder' => 'Mật khẩu mới...'])->label("Mật khẩu mới") ?>
                <?= $form->field($formModel, 'newPassword2')->passwordInput(['id' => 'newPassword2', 'placeholder' => 'Xác nhận mật khẩu mới...'])->label("Xác nhận mật khẩu mới") ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="showpass">
                    <label class="form-check-label" for="showpass">
                        Hiển thị mật khẩu
                    </label>
                </div>
                <?= Html::hiddenInput('_method', 'PATCH', ['id' => '_method']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?=  Html::submitButton('Xác nhận', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>



<div class="card" style="border: 0px; margin-top: 13px;">
    <div class="card-body">
        <h4>Thông tin cá nhân</h4>
        <?= Alert::widget() ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-5">
        <div class="card" style="border: 0px; margin-top: 13px;">
            <div class="card-body" style="flex-direction: column; text-align: center;">
                <img src="<?= Yii::$app->request->baseUrl ?>/image/avt.jpg" alt="Image" style="border-radius: 100%; border: 1px solid black;width: 150px;">
                <h4><?= $info_user-> name?></h4>
                <br>
                <div class="row d-flex align-items-end justify-content-center">
                    <div class="col-auto">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="Edit()">Chỉnh sửa</button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal2">Đổi mật khẩu</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="card" style="border: 0px; margin-top: 13px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">User Name</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?= $info_user-> username?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Name</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?= $info_user-> name?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Email</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?= $info_user-> email?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Phân quyền</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?= $info_user-> role?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-3">
                        <p class="mb-0">Description</p>
                    </div>
                    <div class="col-sm-9">
                        <p class="text-muted mb-0"><?= $info_user-> description?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function Edit(){
        $('#username').val('<?= $info_user-> username?>');
        $('#name').val('<?= $info_user-> name?>');
        $('#email').val('<?= $info_user-> email?>');
        $('#password').val('<?= $info_user-> password?>');
        $('#password').prop('disabled', true);
        $('#role').val('<?= $info_user-> role?>');
        $('#description').val('<?= $info_user-> description?>');
    }

    document.getElementById('showpass').addEventListener('change', function() {
        var password = document.getElementById('oldpassword');
        var newPassword1 = document.getElementById('newPassword1');
        var newPassword2 = document.getElementById('newPassword2');
        if (this.checked){
            password.type = "text";
            newPassword1.type = "text";
            newPassword2.type = "text";
        }
        else{
            password.type = "password";
            newPassword1.type = "password";
            newPassword2.type = "password";
        }
    });
</script>