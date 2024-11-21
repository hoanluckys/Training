<?php
    use yii\widgets\ActiveForm;
    use app\models\User1;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use app\widgets\Alert;
?>

<?php
    $this->title = 'Đăng nhập';
    $this->params['breadcrumbs'][] = $this->title;

//    $model = new User1;
    $form = ActiveForm::begin([
        'action' => ['site/login'],
        'method' => 'post',
    ]);
?>
<style>
.has-error .help-block {
    color: red;
}
</style>
<!-- form ddanwgn nhập -->
<br>
<br>
<br>
<div class="row d-flex align-items-end justify-content-center">
   <div class="col-5">
       <div class="card">
           <div class="card-body">
               <?= Alert::widget() ?>
               <h1><center>Đăng nhập</center></h1>
               <?= $form->field($model, 'username')->textInput(['placeholder' => 'Nhập tài khoản...'])->label('Tài khoản') ?>
               <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu...'])->label('Mật khẩu') ?>
               <center><a href="#" style="text-decoration: none;" data-bs-toggle="modal" data-bs-target="#exampleModal2">Chưa có tài khoản?</a></center>
               <?=  Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary']) ?>
           </div>
       </div>
   </div>
</div>

<?php ActiveForm::end(); ?>

<?php
$model2 = new User1();
$form2 = ActiveForm::begin([
    'id' =>  'formUser',
    'action' => Url::to(['user/create']),
    'method' => 'post',
]);
?>
<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đăng ký</h5>
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
                    ['id' => 'role']
                ) ?>

                <?= $form->field($model, 'description')->textarea(['id' => 'description', 'placeholder' => 'Mô tả...']) ?>
                <?= Html::hiddenInput('_method', 'POST', ['id' => '_method']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?=  Html::submitButton('Xác nhận', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
