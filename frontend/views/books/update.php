<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Authors;
use yii\helpers\ArrayHelper;

$this->title = 'update';
?>
<h1>books/update</h1>

<p>
    You may change the content of this page by modifying
    the file <code><?= __FILE__; ?></code>.
</p>


<?php $form = ActiveForm::begin([
    'id' => 'book-update-form',
    'options' => ['enctype' => 'multipart/form-data'],
]); ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
    'language' => 'ru',
])->textInput(['placeholder' => 'Дата выхода']) ?>

<?= $form->field($model, 'author_id')->dropDownList(
    ArrayHelper::map(Authors::find()->all(), 'id', 'fullName'),
    ['prompt'=>'автор']
); ?>
<?= $form->field($model, 'preview')->fileInput() ?>


<div class="form-group">
    <?= Html::submitButton('update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
</div>

<?php ActiveForm::end(); ?>
