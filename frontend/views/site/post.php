<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\categories\Categories;

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>Create category</h3>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'categories-form']); ?>

            <?= $form->field($modelCategory, 'title_category')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Category', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <h3>Create post</h3>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'post-form']); ?>

            <?= $form->field($modelPost, 'id_category')->dropdownList(ArrayHelper::map(Categories::find()->all(), 'id', 'title_category')) ?>

            <?= $form->field($modelPost, 'title_post')->textInput() ?>

            <?= $form->field($modelPost, 'text_post')->textarea(['rows' => 7]) ?>

            <div class="form-group">
                <?= Html::submitButton('Post', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
