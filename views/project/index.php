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
$this->title = 'Quản lý Project';
$this->params['breadcrumbs'][] = $this->title;


//$model = new Project();
$form = ActiveForm::begin([
    'id' =>  'formUser',
    'action' => ['project/create'],
    'method' => 'post',
]);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm dự án mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= $form->field($model, 'name')->textInput(['id' => 'name', 'placeholder' => 'Tên dự án...']) ?>

                <?php
                    if (Yii::$app->user->can('admin')){
                        echo $form->field($model, 'projectManagerId')->dropDownList(
                            \yii\helpers\ArrayHelper::map($projectManager, 'id', 'name'),
                            ['id' => 'projectManagerId']
                        )->label("Người quản lý");
                    }
                ?>
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



<div class="card" style="border: 0px; margin-top: 13px;">
    <div class="card-body table-responsive">
        <?php if (!Yii::$app->user->can('staff')) { ?>
        <a class="btn btn-success" href="create">+ Thêm dự án mới</a>
        <?php } ?>
        <br>
        <br>
        <?php
        echo GridView::widget([
            'dataProvider' => $alldata,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'name',
                [
                    'attribute' => 'projectManager',
                    'value' => function ($model) {
                        return $model->projectManager ? $model->projectManager->name : 'Không có';
                    },
                ],
                [
                    'attribute' => 'Quantity Project',
                    'value' => function ($model) {
                        return count($model->projectstaff);
                    },
                ],
                'description',
                'createDate',
                'updateDate',
                [
                    'label' => 'Operation',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<a class="btn btn-warning" href="update?id='.$model->id.'">Sửa</a> '.' <button class="btn btn-danger" onclick="Delete('.$model->id.')">Xóa</button>';
                    },
                ],
            ],
        ]);
        ?>
    </div>
</div>
<script>
    function Delete(idProject){
        let result = confirm("Bạn có chắc chắn muốn xóa?");
        if (!result) return 0;
        $.ajax({
            url: '<?= Url::to(['project/delete']) ?>?id='+idProject,
            type: 'DELETE',
            success: function(response) {
                // alert('Xóa thành công');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra: '+ error);
            }
        });
    }

    function Edit(idProject){
        $('#formUser').attr('action', '<?= Url::to(['project/update']) ?>?id='+idProject);
        $('#_method').val("PATCH");
        $.ajax({
            url: '<?= Url::to(['project/view']) ?>?id='+idProject,
            type: 'GET',
            // data: { id: idProject },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    $('#name').val(response.name);
                    $('#projectManagerId').val(response.projectManagerId);
                    $('#description').val(response.description);
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra, vui lòng thử lại!');
            }
        });
    }

    var myModalEl = document.getElementById('exampleModal')
    myModalEl.addEventListener('hidden.bs.modal', function (event) {
        $('#formUser').attr('action', '<?= Url::to(['project/create']) ?>');
        $('#_method').val("POST");
    })
</script>