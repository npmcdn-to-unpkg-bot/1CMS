<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Widgetus */

$this->title = 'Create Widgetus';
$this->params['breadcrumbs'][] = ['label' => 'Widgetuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="widgetus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
