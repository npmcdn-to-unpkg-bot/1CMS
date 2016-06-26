<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use yii\bootstrap\ActiveForm;
use app\modules\admin\models\Comments;
use app\modules\admin\models\Categories;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Posts */

$comm = new Comments();
$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (!Yii::$app->user->getisGuest()) { ?>
        <p>
            <?php if (\Yii::$app->user->can('updateOwnNews', ['news' => $model]) || \Yii::$app->user->can('admin')): ?>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
            <?php if (\Yii::$app->user->can('admin')): ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this post?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </p>
    <?php } ?>

    <div class="panel panel-default">
        <div class="panel-heading"><?= $model->title ?></div>
        <img class="img-responsive" src="<?= $model->img ?>">
        <hr>
        <p style="text-indent: 10px;">
            <b>Author: </b><?= User::findOne($model->author_id)->username; ?> |
            <b>Category: </b><?= Categories::findOne($model->categories_id)->title; ?> |
            <b>Tags: </b><?= $model->tags ?></p>
        <hr>
        <div class="panel-body">
            <?= Html::decode($model->text) ?>
        </div>
    </div>

    <div class="container-fluid">
        <h3>Analogous articles:</h3>
        <?php $similar = \app\modules\blog\models\Posts::find()->where(['categories_id' => $model->categories_id])->limit(3)->all();
        foreach ($similar as $post): ?>
                <a href="<?= \yii\helpers\Url::to(['/blog/view', 'id'=>$post->id])?>"><?= $post->title ?></a>
        <?php endforeach; ?>
    </div>


    <div class="container-fluid">
        <h3>Comments:</h3>
        <?php foreach ($comments as $comment): ?>
            <?php if ($comment->status == true): ?>

                <div class="col-xs-10 comment-text">
                    <h5><b><?= User::findOne($comment->user_id)->username; ?></b> commented:</h5>
                    <p><h6><i>"<?= $comment->text ?>"</i></h6></p>
                </div>
                <? if (Yii::$app->user->can('admin')): ?>
                    <div class="col-xs-2">
                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/admin/comments/del', 'id' => $comment->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this?',
                                'method' => 'post',
                            ]
                        ]) ?>
                    </div>
                <? endif; ?>
            <? else: ?>
                <? if (Yii::$app->user->can('admin')): ?>
                    <div class="col-xs-10 comment-text inactive">
                        <h5><b><?= User::findOne($comment->user_id)->username; ?></b> commented:</h5>
                        <p><h6><i>"<?= $comment->text ?>"</i></h6></p>
                    </div>
                    <div class="col-xs-2">

                        <?= Html::a('<span class="glyphicon glyphicon-ok"></span>', ['/blog/default/activate', 'id' => $comment->id], [
                            'data' => [
                                'confirm' => 'Confirm this comment?',
                                'method' => 'post',
                            ]
                        ]) ?>

                        <?= Html::a('<span class="glyphicon glyphicon-remove"></span>', ['/admin/comments/del', 'id' => $comment->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this comment?',
                                'method' => 'post',
                            ]
                        ]) ?>
                    </div>
                <? endif; ?>
            <? endif; ?>
        <? endforeach; ?>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($comm, 'text')->textInput(['maxlength' => true]) ?>

        <?= Html::activeHiddenInput($comm, 'user_id', ['value' => Yii::$app->user->identity->id]) ?>

        <?= Html::activeHiddenInput($comm, 'post_id', ['value' => $model->id]) ?>

        <div class="form-group">
            <?= Html::submitButton('Leave comment', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    <?php endif; ?>

</div>
