<?php

/* @var $this yii\web\View */
/* @var $model \app\modules\resume\models\Resume */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\grid\GridView;
use app\modules\resume\widgets\topMenu\TopMenuWidget;

$this->title = 'Список резюме';
?>

<?= TopMenuWidget::widget() ?>

<div class="resume-index">
    <h1><?= $this->title ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'description',
            'actions' => [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Действия',
                'template' => '{view} {update} {delete}',
            ]
        ],
    ])
    ?>
</div>    