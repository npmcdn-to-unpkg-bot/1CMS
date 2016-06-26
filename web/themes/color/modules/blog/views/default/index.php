<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\blog\models\PostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('js/masonry.pkgd.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://npmcdn.com/imagesloaded@4.1.0/imagesloaded.pkgd.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('js/grid.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
    <div class="posts-index">

        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php if (!Yii::$app->user->getisGuest()) { ?>
            <p>
                <?= Html::a('New Post', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
        <?php } ?>

        <div class="row" id="post-grid">
            <?php foreach ($posts as $arr) { ?>
                <div class="col-xs-6 news-item">
                    <div class="thumbnail">
                        <img src="<?= $arr->img ?>" alt="...">
                        <div class="caption">
                            <h3> <?= $arr->title ?> </h3>
                            <p><?= $arr->text_preview ?></p>
                            <p><a href="<?= Url::to(['/blog/default/view', 'id'=>$arr->id])?>" class="btn btn-primary" role="button">
                                    More... </a></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

<?= \yii\widgets\LinkPager::widget([
    'pagination' => $pages,
]); ?>