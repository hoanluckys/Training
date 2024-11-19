<?php
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


$model = new Project();
$form = ActiveForm::begin([
    'id' =>  'formUser',
    'action' => '',
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
<!--                --><?php //= $form->field($model, 'projectManagerId')->textInput(['id' => 'projectManagerId', 'placeholder' => 'Email...'])->label("Người quản lý") ?>
                <?= $form->field($model, 'projectManagerId')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\app\models\User1::find()->all(), 'id', 'name'),
//                    ['value' => '2'],
                    ['id' => 'projectManagerId']
                )->label("Người quản lý") ?>
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
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Thêm dự án mới</button>
        <br>
        <br>
        <table class="table table-hover">
            <tr>
                <th>STT</th>
                <th>Name</th>
                <th>Project Manager</th>
                <th>Description</th>
                <th>Create Date</th>
                <th>Update Date</th>
            </tr>
            <?php foreach($alldata as $key => $value){?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value->name?></td>
                    <td><?= $value->projectManager ? $value->projectManager->name : 'Không có.' ?></td>
                    <td><?= $value->description?></td>
                    <td><?= $value->createDate?></td>
                    <td><?= $value->updateDate?></td>
                    <td>
                        <button class = "btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="Edit(<?= $value->id ?>)">Sửa</button>
                        <button class = "btn btn-danger" onclick="Delete('<?= $value->id ?>')">Xóa</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>
<script>
    function Delete(idProject){
        let result = confirm("Bạn có chắc chắn muốn xóa?");
        if (!result) return 0;
        $.ajax({
            url: '<?= Url::to(['/admin/project']) ?>/'+idProject,
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
        $('#formUser').attr('action', '<?= Url::to(['/admin/project']) ?>/'+idProject);
        $('#_method').val("PATCH");
        $.ajax({
            url: '<?= Url::to(['/admin/project']) ?>/'+idProject,
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
        $('#formUser').attr('action', '<?= Url::to(['/admin/project']) ?>');
        $('#_method').val("POST");
    })
</script>