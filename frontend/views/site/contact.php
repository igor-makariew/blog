<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <form method="POST" action="site/forms" id="contact-form">
                <div id="parentId">
                    <div>
                        <input name="name_1" type="text"  placeholder="fio"/>
                        <a onclick="return deleteField(this)" href="#">[X]</a>
                        <br>
                        <br>
                        <input name="name_2" type="text" placeholder="email"/>
                        <a onclick="return deleteField(this)" href="#">[X]</a>
                    </div>
                </div>
                <br>
                <input class="s" type="submit" value="Submit" id="send"/>
            </form>
            <a onclick="return addField()" href="#">+</a>
        </div>
    </div>

    <div id="response"></div>

</div>
