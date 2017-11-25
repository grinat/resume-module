<?php

/* @var $this yii\web\View */
/* @var $model \app\modules\resume\models\Resume */

use yii\widgets\DetailView;
use app\modules\resume\widgets\topMenu\TopMenuWidget;

$this->title = 'Просмотр резюме';
?>

<?= TopMenuWidget::widget() ?>

<div class="resume-view">
    <h1><?= $this->title ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description',
            [
                'label' => 'Список компетенций',
                'format' => 'raw',
                'value' => function($model, $widget) {
                    $html = '';
                    /* @var $resumeCompetence \app\modules\resume\models\ResumeCompetence */
                    foreach ($model->resumeCompetencies as $resumeCompetence) {
                        $html .= '<tr>' .
                                '<td>' . $resumeCompetence->raiting . '</td>' .
                                '<td>' . $resumeCompetence->title . '</td>' .
                                '</tr>';
                    }
                    return $html ? '<table class="table"><tr><td>Оценка</td><td>Навык</td></tr>' . $html . '</table>' : null;
                }
            ]
        ],
    ]);
    ?>
</div>   