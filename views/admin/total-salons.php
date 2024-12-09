<?php

use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\Modal;
use yii\widgets\ActiveForm;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Salons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .btn.service {
            --bs-btn-color: #fff;
            --bs-btn-bg: #30445AFF;
            --bs-btn-border-color: #30445AFF;
            --bs-btn-hover-color: #fff;
            --bs-btn-hover-bg: #30445AFF;
            --bs-btn-hover-border-color: #30445AFF;
        }

        .modal-title {
            font-family: serif;
            font-weight: bolder;
            color: #000;
        }
        .form-group .btn-create{
            background: #30445AFF;
            color: wheat;
        }
        .modal-body {
            font-family: serif;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="view-table col-md-12">
        <div class="card m-3">
            <div class="card-header d-flex align-items-center">
                <h2 class="card-title fs-3" style="font-family:tahoma">Total Salons<i class="bi bi-people-fill mx-2"></i></h2>
                <button id="showCreateForm" class="btn btn-light ms-auto">
                    <i data-feather="plus-square" class="text-primary" style="width: 36px; height: 36px;"></i>
                </button>
                <div class="p-2">
                    <?= Html::a('PDF', ['/site/generate'], [
                        'class' => 'btn btn-danger',
                        'target' => '_blank',
                        'data-toggle' => 'tooltip',
                        'title' => 'Will open the generated PDF file in a new window',
                    ]) ?>
                </div>
                <div class="p-2">
                    <?= Html::a('Excel', ['/site/generate-excel'], [
                        'class' => 'btn btn-success',
                        'target' => '_blank',
                        'data-toggle' => 'tooltip',
                        'title' => 'Will open the generated Excel file in a new window',
                    ]) ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary text-start fs-5" style="font-family:tahoma;">
                            <tr>
                                <th>No</th>
                                <th>Salon Name</th>
                                <th>Category</th>
                                <th>Address</th>
                                <th>Working Days</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($salons as $data): ?>
                                <tr class="table-light text-start fs-6" style="font-family:tahoma">
                                    <td><?= $no ?></td>
                                    <td><?= Html::encode($data['name']) ?></td>
                                    <td><?= Html::encode($data->getFormattedTypes()) ?></td>
                                    <td><?= Html::encode($data['address']) ?></td>
                                    <td><?= Html::encode($data->getFormattedWorkingDays()) ?></td>
                                    <td><?= $data->owner ? Html::encode($data->owner->username) : 'N/A' ?></td>
                                    <td><?= Html::encode($data['status']) ?></td>
                                    <td>
                                        <button class="btn btn-sm" id="view-salon" data-id="<?= $data['id'] ?>">
                                            <i data-feather="eye" class="me-2 text-primary"></i>
                                        </button>
                                        <a href="<?= Url::to(['admin/update', 'id' => $data['id']]) ?>">
                                            <i data-feather="edit" class="me-2 text-success"></i>
                                        </a>
                                        <a href="#" class="delete-user" data-id="<?= $data['id'] ?>">
                                            <i data-feather="trash-2" class="text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $no++; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination-container d-flex justify-content-end mt-3">
                    <?= LinkPager::widget(['pagination' => $pagination]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center" id="salonForm" style="display: none;">
        <div class="col-8 mx-auto">
            <div class="card border-0">
                <div class="card-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['admin/create'],
                        'method' => 'post',
                        'options' => ['enctype' => 'multipart/form-data']
                    ]); ?>
                    <div class="pt-3 mb-3">
                        <?= $form->field($salon, 'salon_image')->fileInput()->label('Salon Image') ?>
                    </div>
                    <div class="pt-3">
                        <?= $form->field($salon, 'name')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Name : ') ?>
                    </div>
                    <div class="pt-3">
                        <?= $form->field($salon, 'address')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Location :') ?>
                    </div>
                    <div class="pt-3">
                        <?= $form->field($salon, 'owner_id')->textInput(['class' => 'form-floating border    mx-4 rounded'])->label('Salon Owner') ?>
                    </div>
                    <div class="pt-3">
                        <?= $form->field($salon, 'type')->checkboxList([
                            1 => 'Bridal Salon',
                            2 => 'Hair Salon',
                            3 => 'MANI + PEDI SALON',
                            4 => 'Barber Shop',
                            5 => 'Skin Care Clinic',
                            6 => 'Makeup',
                        ])->label('Type :') ?>
                    </div>
                    <div class="pt-3 mb-3">
                        <?= $form->field($salon, 'description')->textarea(['class' => 'form-floating border    mx-4', 'rows' => '3'])->label('Description : ') ?>
                    </div>
                    <div class="pt-3 mb-3">
                        <?= $form->field($salon, 'working_days')->checkboxList(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'])->label('Working Days') ?>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <?= Html::submitButton('Create Salon', ['class' => 'btn btn-create']) ?>
                        <?= Html::a('Cancel', ['dashboard'], ['class' => 'btn btn-danger']) ?>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="salonDetailsModal" tabindex="-1" aria-labelledby="salonDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="salonDetailsModalLabel">Salon Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="salonDetailsContent">
                    <!-- Salon details will be injected here via AJAX -->
                </div>
                <div class="modal-footer">
                    <a href="<?= Url::to(['services/create', 'salonId' => $salon->id ?? null]) ?>" class="btn border rounded service">
                        Add Service
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#showCreateForm').on('click', function(event) {
                event.preventDefault();
                $('.view-table').hide();
                $('#salonForm').show();
            });

            $('#salonForm').validate({
                submitHandler: function(form) {
                    var formData = $(form).serialize();
                    $.ajax({
                        url: 'admin/create-salon',
                        method: 'POST',
                        data: formData,
                        success: function(response) {
                            if (response.success) {
                                $('#salonForm').hide();
                                $('.view-table').show();
                            } else {
                                alert('Failed to create salon. Please try again.');
                            }
                        }
                    });
                }
            });

            $('#view-salon').on('click', function() {
                var salonId = $(this).data('id');
                if (salonId) {
                    viewSalon(salonId);
                }
            });

            function viewSalon(id) {
                $.ajax({
                    url: '<?= Url::to(['admin/view-salon']) ?>',
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        if (response.error) {
                            alert(response.error);
                        } else {
                            $('#salonDetailsModalLabel').text(response.name);
                            $('#salonDetailsContent').html(response.details);

                            var salonModal = new bootstrap.Modal(document.getElementById('salonDetailsModal'));
                            salonModal.show();
                        }
                    },
                    error: function() {
                        alert('Error fetching salon details.');
                    }
                });
            }
        });
    </script>

</body>

</html>