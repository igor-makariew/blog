<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\posts\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text_post')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

<!--    --><?//= $form->field($model, 'id_user')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'id_category')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'status_post')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
