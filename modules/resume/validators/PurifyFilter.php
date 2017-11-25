<?php
namespace app\modules\resume\validators;

use yii\validators\Validator;
use yii\helpers\HtmlPurifier;

class PurifyFilter extends Validator
{
    /**
     * @var boolean whether the filter should be skipped if an array input is given.
     * If true and an array input is given, the filter will not be applied.
     */
    public $skipOnArray = false;
    
    public $options;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        if (!$this->skipOnArray || !is_array($value)) {
            $model->$attribute = HtmlPurifier::process($value, $this->options);
        }
    }


}
