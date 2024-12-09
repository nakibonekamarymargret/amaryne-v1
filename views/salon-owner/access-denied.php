<?php

use yii\helpers\Html;

$this->title = 'Access Denied';
?>
<div class="site-error">
    <h1> 😢 Oops,<?= Html::encode($this->title) ?></h1>
    <p>You do not have the necessary permissions to access this page.</p>
    <p>
        If you believe this is an error, please contact the site administrator.
    </p>
    
    <a href="<?= Yii::$app->homeUrl ?>" class="btn  border rounded" style=" background-color: #f4a300; color:white"> Go Back to Home</a>
</div>
<?php
