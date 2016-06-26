<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Widgetus;
use yii\helpers\ArrayHelper;

$widgets = Widgetus::find()->all();

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Widgetus */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
$dir = Yii::$app->basePath . '/components';
$results = scandir($dir);

foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;

    if (is_dir($dir . '/' . $result)) {
        continue;
    }
    $res = explode('.php', $result);
    $key = $res[0];
    $files[$key] = $res[0];
}
?>

<div class="widgetus-form">
    <div style="width: 65%; float: left; ">
    </div>

    <div style="background-color: #00b3ee; width: 35%; float: right; ">
        <h2 style="text-align: center">RIGHT SIDEBAR</h2><br>
        <?php
        $base = Widgetus::find()->where(['zone' => 'rsb'])->all(); ?>
        <ul>
            <?php foreach ($base as $widget): ?>
                <li><?= $widget->name; ?>
                    <?= Html::a('Delete', ['delete', 'id' => $widget->id], [
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this item?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'name')->dropDownList($files) ?>
        <?= $form->field($model, 'zone')->hiddenInput(['value' => 'rsb'])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div style="background-color: orangered; width: 100%; float: right; text-align: center">
        <h2>FOOTER</h2>
        <div class="col-xs-6">
            <?php
            $base = Widgetus::find()->where(['zone' => 'foo'])->all(); ?>
            <ul>
                <?php foreach ($base as $widget): ?>
                    <li><?= $widget->name; ?>  <?= Html::a('Delete', ['delete', 'id' => $widget->id], [
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-xs-6">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name')->dropDownList($files) ?>
            <?= $form->field($model, 'zone')->hiddenInput(['value' => 'foo'])->label(false) ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
