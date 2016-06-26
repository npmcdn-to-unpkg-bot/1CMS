<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Mediafiles */

$this->title = 'Create Mediafiles';
$this->params['breadcrumbs'][] = ['label' => 'Mediafiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mediafiles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
