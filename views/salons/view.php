<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class="salon-content">
    <div class="saloon justify-content-center text-center px-5">
        <img src="<?= Yii::$app->request->baseUrl . '/' . Html::encode($salon->salon_image) ?>"
            alt="<?= Html::encode($salon->name) ?>" style="width:auto; height: 200px; object-fit:cover;">
        <h1><?= Html::encode($salon->name) ?></h1>
        <p><?= Html::encode($salon->description) ?></p>
    </div>
    <div class="zigzag-line"></div>
    <h2 class="text-center">Services</h2>
    <div class="row">
        <?php foreach ($services as $service): ?>
            <div class="col-md-4 mb-4">
                <div class="service-card">
                    <h5 class="card-title text-center mt-3"><?= Html::encode($service->name) ?></h5>
                    <div class="position-relative">
                        <?php if (!empty($service->discount)): ?>
                            <div class="badge bg-danger text-white position-absolute top-0 end-0 m-2"
                                style="z-index: 10; font-size: 0.9rem;">
                                <?= number_format($service->discount, 0) ?>%
                            </div>
                        <?php endif; ?>
                        <img src="<?= Yii::$app->request->baseUrl . '/' . Html::encode($service->service_image) ?>"
                            class="card-img-top" alt="<?= Html::encode($service->name) ?>"
                            style="width: 100%; height:200px; object-fit:cover;">
                        <p class="service-description mt-2"><?= Html::encode($service->description) ?></p>

                        <div class="text-start mt-3 d-flex align-items-center justify-content-between">
                            <div class="price-details">
                                <?php if (!empty($service->discount)):
                                    // Calculate discounted price
                                    $discountedPrice = $service->price - ($service->price * ($service->discount / 100)); ?>
                                    <div>
                                        <span class="text-muted original-price"
                                            style="display: block; text-decoration: line-through;">
                                            <?= Html::encode($service->price) ?>/=
                                        </span>
                                        <span class="fw-bold discounted-price" style="display: block; margin-top: 5px;">
                                            <?= number_format($discountedPrice, 0) ?>/=
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <span class="fw-bold">
                                            <?= Html::encode($service->price) ?>/=
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#appointmentModal" data-service-id="<?= $service->id ?>"
                                data-service-name="<?= Html::encode($service->name) ?>" data-salon-id="<?= $salon->id ?>">
                                Book Appointment
                            </button>

                        </div>

                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- book appointment -->

<div class="modal fade" id="appointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="appointmentModalLabel">
                    Hi <?= Html::encode($customer->name) ?>, Create Your Appointment
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="appointment-form">
                    <?php $form = ActiveForm::begin([
                        'action' => ['customer/appointment', 'salon_id' => $salon->id],
                        'method' => 'post',
                    ]); ?>


                    <?= $form->field($appointment, 'customer_id')->hiddenInput(['value' => $customer->id])->label(false) ?>
                    <?= $form->field($appointment, 'service_id')->hiddenInput(['id' => 'service-id'])->label(false) ?>
                    <?= $form->field($appointment, 'salon_id')->hiddenInput(['id' => 'salon_id'])->label(false) ?>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" value="<?= Html::encode($customer->email) ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label>Telephone</label>
                        <input type="text" class="form-control" value="<?= Html::encode($customer->contact) ?>"
                            readonly>
                    </div>

                    <?= $form->field($appointment, 'appointment_date')->input('date') ?>

                    <?= $form->field($appointment, 'appointment_time')->input('time') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Book Appointment', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const appointmentModal = document.getElementById('appointmentModal');
        appointmentModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const salonId = button.getAttribute('data-salon-id');
            const serviceId = button.getAttribute('data-service-id');

            document.getElementById('salon-id').value = salonId;
            document.getElementById('service-id').value = serviceId;
        });
    });

</script>