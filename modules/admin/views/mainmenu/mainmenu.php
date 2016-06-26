<?php
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Mainmenu */
/* @var $form ActiveForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\models\Mainmenu;

$this->registerJsFile("https://code.jquery.com/jquery-2.2.4.min.js", ['position' => \yii\web\View::POS_HEAD]);

$menu = Mainmenu::find()->all();
?>

<?php $form = ActiveForm::begin(); ?>

<?php foreach ($menu as $key => $value): ?>
<div class="row" id="<?=$key ?>">
    <div class="col-xs-4"><?= $form->field($value, "[$key]title") ?></div>
    <div class="col-xs-4"><?= $form->field($value, "[$key]url") ?></div>
    <div class="col-xs-3"><?= $form->field($value, "[$key]number") ?></div>
    <div class="col-xs-1"><div class="btn btn-danger remove" remove="<?=$key ?>">X</div></div>
</div>
<?php endforeach; ?>

<input type="hidden" id="key" key="<?= $key + 1 ?>">

<div id="newitems"></div>

<div class="btn btn-success" id="add">Add new item</div>

<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

<script>
    var msg = $('#key').attr('key');
    $('#add').click(function () {
        $.ajax({
            type: 'POST',
            url: '/admin/mainmenu/add',
            data: {
                id: msg
            },
            success: function (data) {
                $('#newitems').append(data);
            },
            error: function (xhr, str) {
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
        });
        msg++;
    });

    $('.remove').click(function(){
        var rem_id = $(this).attr('remove');
        $('div').remove('#' + rem_id);
    });

</script>



