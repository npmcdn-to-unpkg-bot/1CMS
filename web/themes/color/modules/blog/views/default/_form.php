<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use app\modules\admin\models\Categories;

/* @var $this yii\web\View */
/* @var $model app\modules\blog\models\Posts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="posts-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]) ?>

    <?= Html::activeHiddenInput($model, 'author_id', ['value' => Yii::$app->user->identity->id]) ?>

    <?= $form->field($model, 'text_preview')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'categories_id')->dropDownList(ArrayHelper::map(Categories::find()->all(), 'id', 'title')) ?>

    <?php if ($model->img): ?>
        <img src="<?= $model->img ?>">
    <?php endif; ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'img')->fileInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
