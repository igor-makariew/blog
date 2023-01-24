<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['site/verify-email', 'token' => $user->verification_token]);
?>
Привет  <?= $user->username ?>,

ерейдите по ссылке ниже, чтобы подтвердить свой email:

<?= $verifyLink ?>
