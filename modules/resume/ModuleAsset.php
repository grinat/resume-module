<?php
namespace app\modules\resume;

use yii\web\AssetBundle;

class ModuleAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/resume/assets';
    
    public $publishOptions = ['forceCopy' => true];

    public $css = [
        'resume.css'
    ];
    
    public $js = [
        'resume.js'
    ];
    
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


}
