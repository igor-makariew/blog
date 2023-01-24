<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\posts\Posts */

$this->title = $model->title_post;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'title_post',
//            'text_post:ntext',
            [
                'attribute' => 'text_post',
                'format' => 'html',
                'value' => function($model) {
                    return "<div align='justify'>
                                <img src='/backend/web/images/{$model->image}' . style='width: 200px' vspace='10' hspace='10' align='left'>
                                <p>{$model->text_post}</p>
                            </div>";
                }
            ],
            'id_user',
            ['attribute' => 'id_category', 'value' => function($model) {
                return $model->categories->title_category;
            }],
            'status_post',
        ],
    ]) ?>

</div>
