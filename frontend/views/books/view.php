<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<?= DetailView::widget([
    'model' => $book,
    'attributes' => [
        'id',
        'name',
        'date:date',
        'fullName',
        [
            'attribute' => 'preview',
            'format' => 'html',
            'value' => Html::img(Yii::getAlias('@web').'/images/'. $book['preview'], [
                'class' => 'img-w100'
            ]),
        ],
    ],
]) ?>