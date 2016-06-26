<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\MediafilesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mediafiles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mediafiles-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Mediafiles', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'title:ntext',
            'date',
//            'ext',
            'type',
            // 'murl',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
