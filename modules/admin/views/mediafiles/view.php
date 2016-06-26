<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Mediafiles */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Mediafiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mediafiles-view">
    <?php echo '<img class="img-responsive" src="/web/static/icon/' . $model->ext . '.png">';?>
    <!--    <h4>Filename: --><? //= Html::encode($this->title) ?><!--</h4>-->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'id',
            'title:ntext',
            'date',
//            'ext',
            'type',
            'murl',
        ],
    ]) ?>
    <p>
<!--        --><?//= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
