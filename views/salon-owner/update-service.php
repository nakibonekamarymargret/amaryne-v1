<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="edit-form">
    <div class="row mb-3 d-flex mt-4">
        <div class="col-lg-6 mt-5">
            <?= $form->field($model, 'name') ?>
        </div>
        <div class="col-col-lg-6 mt-5">
            <?= $form->field($model, 'description')->textarea(['cols' => 50, 'rows' => 10, 'class' => 'form-control']) ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-sm-4">
            <?= $form->field($model, 'price') ?>
        </div>
        
    </div>
    <div class="row mt-2">
        <div class="d-flex justify-content-center">
            <?= Html::submitButton('Save Changes', ['class' => 'btn btn-success']) ?>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>
<script>
    function editUser(id) {
    $.ajax({
        url: '<?= Yii::$app->urlManager->createUrl(['site/edit', 'id' => '']) ?>' + id,
        type: 'GET',
        success: function(response) {
            $('#editUserContent').html(response);
            $('#editUserModal').modal('show');
        },
        error: function() {
            alert('Error loading edit form.');
        }
    });
}

</script>