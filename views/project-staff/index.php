<?php

use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\models\Project;
use app\models\User1;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>


<?php
$this->title = 'Quản lý Project nhân viên';
$this->params['breadcrumbs'][] = $this->title;

if (!Yii::$app->user->can('staff')){

$form = ActiveForm::begin([
    'id' =>  'formUser',
    'action' => ['project-staff/create'],
    'method' => 'post',
]);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm nhân viên vào dự án</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?=
                $form->field($model, 'projectId')->dropDownList(
                    \yii\helpers\ArrayHelper::map($all_project, 'id', 'name'),
                )->label("Chọn dự án");
                ?>
                <?=
                $form->field($model, 'userId')->dropDownList(
                    \yii\helpers\ArrayHelper::map($staffs, 'id', 'name'),
//                    [
//                        'multiple' => true,
//                        'size' => 10,
//                        'value' => '9'
//                    ]
                )->label("Chọn nhân viên");
                ?>
                <?= Html::hiddenInput('_method', 'POST', ['id' => '_method']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <?=  Html::submitButton('Thêm', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php
ActiveForm::end();
}
?>


<div class="card" style="border: 0px; margin-top: 13px;">
    <div class="card-body table-responsive">
        <?php if (!Yii::$app->user->can('staff')){ ?>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Thêm nhân viên mới vào dự án</button>
        <?php } ?>
        <br>
        <br>
        <?php
        echo GridView::widget([
            'dataProvider' => $alldata,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'Name Staff',
                    'value' => function ($model) {
                        return $model->user ? $model->user->name : 'Không có';
                    },
                ],
                [
                    'attribute' => 'Name Project',
                    'value' => function ($model) {
                        return $model->project ? $model->project->name : 'Không có';
                    },
                ],
                [
                    'attribute' => 'Description',
                    'value' => function ($model) {
                        return $model->project ? $model->project->description : 'Không có';
                    },
                ],
                [
                    'attribute' => 'Created Date',
                    'value' => function ($model) {
                        return $model->project ? $model->project->createDate : 'Không có';
                    },
                ],
                [
                    'attribute' => 'Updated Date',
                    'value' => function ($model) {
                        return $model->project ? $model->project->updateDate : 'Không có';
                    },
                ],
                [
                    'label' => 'Operation',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<button class="btn btn-danger" onclick="Delete('.$model->id.')">Xóa</button>';
                    },
                ],
            ],
        ]);
        ?>
    </div>
</div>
<script>
    function Delete(idProjectStaff){
        let result = confirm("Bạn có chắc chắn muốn xóa?");
        if (!result) return 0;
        $.ajax({
            url: '<?= Url::to(['project-staff/delete']) ?>?id='+idProjectStaff,
            type: 'DELETE',
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra: '+ error);
            }
        });
    }
</script>