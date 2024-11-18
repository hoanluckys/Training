<?php
use yii\widgets\ActiveForm;
use app\models\User1;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;
?>


<?php
$this->title = 'Quản lý người dùng';
$this->params['breadcrumbs'][] = $this->title;


$model = new User1();
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
                <h5 class="modal-title">Thêm người dùng mới</h5>
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
                        'PM' => 'Project Management',
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

<div class="card" style="border: 0px; margin-top: 13px;">
    <div class="card-body table-responsive">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Thêm người dùng mới</button>
        <br>
        <br>
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Name</th>
                <th>Email</th>
                <th>Description</th>
                <th>Operation</th>
            </tr>
            <?php foreach($alldata as $key => $value){?>
                <tr>
                    <td><?= $value->ID ?></td>
                    <td><?= $value->username?></td>
                    <td><?= $value->name?></td>
                    <td><?= $value->email?></td>
                    <td><?= $value->description?></td>
                    <td>
                        <button class = "btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="Edit(<?= $value->ID ?>)">Sửa</button>
                        <button class = "btn btn-danger" onclick="Delete('<?= $value->ID ?>')">Xóa</button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?= LinkPager::widget(['pagination' => $pagination]) ?>
    </div>
</div>
<script>
    function Delete(idUser){
        let result = confirm("Bạn có chắc chắn muốn xóa?");
        if (!result) return 0;
        $.ajax({
            url: '<?= Url::to(['/admin/user']) ?>/'+idUser,
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

    function Edit(idUser){
        $('#formUser').attr('action', '<?= Url::to(['/admin/user']) ?>/'+idUser);
        $('#_method').val("PATCH");
        $.ajax({
            url: '<?= Url::to(['/admin/user']) ?>/'+idUser,
            type: 'GET',
            // data: { id: idUser },
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    $('#username').val(response.username);
                    $('#name').val(response.name);
                    $('#email').val(response.email);
                    $('#password').val(response.password);
                    $('#password').prop('disabled', true);
                    $('#role').val(response.role);
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
        $('#formUser').attr('action', '<?= Url::to(['/admin/user']) ?>');
        $('#_method').val("POST");
    })
</script>