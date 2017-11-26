<?php
namespace app\modules\resume;

use yii\base\BootstrapInterface;

/**
  Задача
  Необходимо создать веб-сервис для сохранения, просмотра и удаления резюме.
  Резюме состоит из двух текстовых полей(название, описание) и списка компетенций.
  Каждая компетенция состоит из названия и оценки уровня(от 1 до 5).

  При сохранении(редактировании) резюме необходимо предусмотреть возможность выбора
  компетенций из ранее введенных значений(автокомплит).

  Требования
  PHP 5/7, PostgreSQL, Yii2, отформатированный и понятный код.
  Можно использовать любые сторонние компоненты.
 */
 
class Module extends \yii\base\Module implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            'resume/resume/index' => 'resume/resume/index',
            'resume/resume/create' => 'resume/resume/create',
            'resume/resume/view/<id:[0-9]+>' => 'resume/resume/view',
            'resume/resume/update/<id:[0-9]+>' => 'resume/resume/update',
            'resume/resume/delete/<id:[0-9]+>' => 'resume/resume/delete',
            'GET resume/competence-suggestion/index' => 'resume/competence-suggestion/index',
        ], true);
    }
}