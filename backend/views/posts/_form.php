<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\categories\Categories;

/* @var $this yii\web\View */
/* @var $model common\models\posts\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_category')->dropdownList(ArrayHelper::map(Categories::find()->all(), 'id', 'title_category')) ?>

    <?= $form->field($model, 'title_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text_post')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_post')->dropdownList([
        '0' => 'On',
        '1' => 'Off',
    ]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
