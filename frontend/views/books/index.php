<?php

use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Button;
use common\models;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\helpers\Html;
use yii\bootstrap\ButtonGroup;

/* @var $this yii\web\View */
?>
<h1>books/view</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>
<?php
$this->registerJsFile('/js/books-index.js');
$this->registerCssFile('/css/books-index.css');

if ($searchModel->dateFrom > 1 &&
    $searchModel->dateTo > 1) {
    $searchModel->dateFrom = Yii::$app->formatter->asDate($searchModel->dateFrom);
    $searchModel->dateTo = Yii::$app->formatter->asDate($searchModel->dateTo);
} else {
    $searchModel->dateFrom = null;
    $searchModel->dateTo = null;
}
?>

<?php
$form = yii\bootstrap\ActiveForm::begin([
    'method' => 'get',
    'action' => ['books/index'],
]); ?>

<div>
    <div style="width: 30%; float: left">
    <?php echo $form->field($searchModel, 'author_id')
        ->dropDownList(
            ArrayHelper::map(models\Authors::find()->all(), 'id', 'fullName'),
            ['prompt'=>'автор']
        )->label(false);?>
    </div>
    <div style="width: 30%; float: left">
        <?php echo $form->field($searchModel, 'name')->label(false)->textInput(['placeholder' => 'Название книги']);?>
    </div>
    <div style="clear: both"></div>
    <div>
        <div style="width: 30%; float: left">
            <?= $form->field($searchModel, 'dateFrom')->widget(DatePicker::classname(), [
                'language' => 'ru',
            ])->label(false)->textInput(['placeholder' => 'Дата выхода c']) ?>
        </div>
        <div style="width: 30%; float: left">
            <?= $form->field($searchModel, 'dateTo')->widget(DatePicker::classname(), [
                'language' => 'ru',
            ])->label(false)->textInput(['placeholder' => 'Дата выхода по']) ?>
        </div>
        <div style="clear: both"></div>
    </div>
</div>
<?php echo Button::widget([
    'label' => 'search',
    'options' => ['class' => 'btn-lg btn-primary'],
]);?>
<?php ActiveForm::end();?>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        'id',
        'name',
        [
            'attribute' => 'preview',
            'format' => 'html',
            'value' => function ($data) {
                return Html::img(Yii::getAlias('@web').'/images/'. $data['preview'],
                    [
                        'width' => '30px',
                        'class' => 'scalable',
                    ]);
            },
        ],
        'fullName',
        'date:date',
        'date_create:date',
        'actions' => [
            'format'=>'raw',
            'value' => function($data){
                return ButtonGroup::widget([
                    'encodeLabels' => false,
                    'options' => [
                        'data-id' => $data['id'],
                    ],
                    'buttons' => [
                        [
                            'options' => ['class' => 'a-edit btn-primary'],
                            'label' => '<span class="glyphicon glyphicon-pencil"></span>'
                        ],

                        [
                            'options' => [
                                'class' => 'a-view btn-primary',
                                'data-toggle' => 'modal',
                                'data-target' => '#modal-window',
                            ],
                            'label' => '<span class="glyphicon glyphicon-eye-open"></span>'

                        ],
                        [
                            'options' => ['class' => 'a-remove btn-primary'],
                            'label' => '<span class="glyphicon glyphicon-remove"></span>'
                        ],

                    ],
                ]);
            }
        ],
    ],
]);

yii\bootstrap\Modal::begin([
    'header' => '<h2>DetailView</h2>',
    'options' => [
        'id' => 'modal-window'
    ],
]);
?>
<div id="modal-content"></div>
<?php yii\bootstrap\Modal::end(); ?>