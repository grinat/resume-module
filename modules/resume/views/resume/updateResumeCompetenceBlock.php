<?php
/* @var $this yii\web\View */
/* @var $resumeCompetence \app\modules\resume\models\ResumeCompetence */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
?>

<div class="resume-competence-item row">

    <?= $form->field($resumeCompetence, 'title', [
                'options' => [
                    'class' => 'form-group col-md-6'
                ]
            ])
            ->label(false)
            ->textInput([
                'placeholder' => $resumeCompetence->getAttributeLabel('title'),
                'name' => $resumeCompetence->formName() . '[title][]',
                'autocomplete' => 'off'
            ])
    ?>

    <?= $form->field($resumeCompetence, 'raiting', [
                'options' => [
                    'class' => 'form-group col-md-4'
                ]
            ])
            ->label(false)
            ->dropDownList($resumeCompetence->getRaitingList(), [
                'prompt' => 'Выберите оценку',
                'name' => $resumeCompetence->formName() . '[raiting][]'
            ])
    ?>

    <?= Html::activeHiddenInput($resumeCompetence, 'id', [
        'name' => $resumeCompetence->formName() . '[id][]',
        ])
    ?>

    <div class="form-group col-md-2">
        <?= Html::a('Удалить', null, ['class' => 'btn btn-block btn-default remove-competence-from-resume']) ?>
    </div>

</div>
