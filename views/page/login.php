<?php
    use yii\widgets\ActiveForm;
    use app\models\User1;
    use yii\helpers\Html;
    // use Yii;
    use yii\widgets\LinkPager;
?>

<?php 
    $model = new User1;
    $form = ActiveForm::begin([
        'action' => '',
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
               <h1><center>Đăng nhập</center></h1>
               <?= $form->field($model, 'username')->textInput(['placeholder' => 'Nhập tài khoản...'])->label('Tài khoản') ?>
               <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nhập mật khẩu...'])->label('Mật khẩu') ?>
               <?=  Html::submitButton('Đăng nhập', ['class' => 'btn btn-primary']) ?>
           </div>
       </div>
   </div>
</div>


<?php ActiveForm::end(); ?>