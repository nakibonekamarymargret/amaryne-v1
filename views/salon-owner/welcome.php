<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Welcome';
?>
<style>
    .container-fluid {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .text-center {
        text-align: center;
    }
    
    button {
        border-radius: 25px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
    
    .btn-primary {
        background-color: #FF9900FF;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #B37A00FF;
    }
    
    .btn-secondary {
        background-color: #02192CFF;
        border: none;
    }
    
    .btn-secondary:hover {
        background-color: #54ABEEFF;
    }
    
    a {
        color: white;
        text-decoration: none;
    }
    
    a:hover {
        text-decoration: underline;
    }

</style>
<div class="container-fluid">
    <div class="row justify-content-center align-items-center">
        <div class="col-9 text-center">
            <div class="site-error">
                <h1><?= Html::encode($this->title) ?> <span class="icon-bye">👋 </span>
                <span class="text-uppercase">
                    <?php if ($model): ?>
                        <?= Html::encode($model->username, ) ?>
                    <?php endif; ?>
                </span>  
                </h1>
                <div class="text mt-3">
                    <p>Please register your salon and services to get started with Amaryne Beauties</p>
                    <div class="d-flex justify-content-center gap-5">
                        <button type="button" class="btn btn-primary">
                            <a href="<?= Url::to(['salon-owner/create-salon']) ?>" style="color: white; text-decoration: none;">Register Salon</a>
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <a href="<?= Url::to(['site/index']) ?>" style="color: white; text-decoration: none;">Later</a>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
