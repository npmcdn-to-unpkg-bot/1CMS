<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use app\modules\blog\models\Posts;
?>

<?php $posts = Posts::find()->orderBy('date_create DESC')->limit(5)->all();
foreach ($posts as $post):
    ?>
    <p>
        <a href="<?= Url::to(['/blog/default/view', 'id' => $post->id]) ?>"><?= $post->title ?></a>
    </p>
<?php endforeach; ?>