<?php
use yii\widgets\ListView

?>
<h2>Found Products </h2>
<?php echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'products',
    'layout' => '<div class" d-flex flex-wrap">{items}</div>{pager}',
    'itemOptions' => [

        'tag' => false
    ]
])
    ?>