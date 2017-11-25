<?php

namespace app\modules\resume\widgets\topMenu;

use yii\base\Widget;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

class TopMenuWidget extends Widget{

    public function run()
    {
        $items = [
            [
                'label' => 'Список резюме',
                'url' => ['/resume/resume/index']
            ],
            [
                'label' => 'Добавить',
                'url' => ['/resume/resume/create']
        ]];
        foreach($items as $key => $item){
            $items[$key]['active'] = (isset($item['url']) && Url::current() == Url::to($item['url']));
        }
        return Tabs::widget(['items' => $items]);
    }
}
