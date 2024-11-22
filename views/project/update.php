<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Tạo mới Project';
$this->params['breadcrumbs'][] = $this->title;


//$model = new Project();
$form = ActiveForm::begin([
    'id' =>  'formProjectCreate',
    'action' => ['project/update', 'id' => $modelProject->id],
    'method' => 'post',
]);
?>
<style>
    .customslect label{
        display: block;
        margin-bottom: 5px;
    }
    .customslect {
        max-height: 100px;
        overflow-y: scroll;
        border: 1px solid #e3e3e3;
        border-radius: 5px;
        margin: 1px;
    }
</style>
<div class="card" style="margin-top: 13px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($modelProject, 'name')->textInput(['id' => 'name', 'placeholder' => 'Tên dự án...', 'value' => $modelProject->name]) ?>
            </div>
            <div class="col-md-6">
                <?php
                if (Yii::$app->user->can('admin')){
                    echo $form->field($modelProject, 'projectManagerId')->dropDownList(
                        \yii\helpers\ArrayHelper::map($projectManager, 'id', 'name'),
                        [
                            'id' => 'projectManagerId',
                            'value' => $modelProject->projectManagerId,
                        ]
                    )->label("Người quản lý");
                }
                ?>
            </div>
            <div class="col-md-6">
                <?= Html::label('Nhân viên', 'userId', ['class' => 'control-label']); ?>
                <div class="row customslect" data-bs-spy="scroll">
                    <?php
                    echo $form->field($modelProjectStaff, 'userId')->checkboxList(
                        \yii\helpers\ArrayHelper::map($staffs, 'id', 'name'),
                        [
                            'id' => 'userId',
                            'unselect' => null,
                        ]
                    )->label('');
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <?= $form->field($modelProject, 'description')->textarea(['id' => 'description', 'placeholder' => 'Mô tả...']) ?>
            </div>
        </div>
        <?=  Html::submitButton('Xác nhận', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
