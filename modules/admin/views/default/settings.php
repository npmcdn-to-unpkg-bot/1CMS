<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$dir = Yii::$app->basePath . '/web/themes';
$results = scandir($dir); 
$res[''] = 'default';
foreach ($results as $result) {
    if ($result === '.' or $result === '..') continue;
    if (is_dir($dir . '/' . $result)) {
        $res[$result] = $result;
    }
    continue;
} 

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Settings */
/* @var $form ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'theme')->dropDownList($res)?>
<?= $form->field($model, 'pagination') ?>
<?= $form->field($model, 'site_title') ?>
<?= $form->field($model, 'site_description') ?>
<?= $form->field($model, 'keywords') ?>
<?= $form->field($model, 'mail_template')->widget(CKEditor::className(), [
    'options' => ['rows' => 6],
    'preset' => 'basic'
]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>