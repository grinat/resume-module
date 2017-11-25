<?php
namespace app\modules\resume\models;

use yii\db\ActiveRecord;
/**
 * Resume-Competence model
 *
 * @property integer $id
 * @property integer $resume_id
 * @property string $title
 * @property integer $raiting
 */
class ResumeCompetence extends ActiveRecord{
    
    const RAITING_RANGE = [1,2,3,4,5];
    const MAX_SUGGESTIONS = 100;
    
    public static function tableName()
    {
        return '{{%resume_competence}}';
    }
    
    public function rules() {
        return [
            [['title'], 'trim'],
            [['title','raiting'], 'required'],
            [['title'], 'app\modules\resume\validators\PurifyFilter'],
            [['title'], 'string', 'min'=>3, 'max'=>200],
            [['raiting'], 'in', 'range'=> static::RAITING_RANGE]
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название компетенции',
            'raiting' => 'Оценка'
        ];
    }
    
    public function getRaitingList(){
        $list = [];
        foreach(static::RAITING_RANGE as $value){
            $list[$value] = $value;
        }
        return $list;
    }
    
    public function getSuggestionsList(){
        $list = static::find()
                ->select('title')
                ->groupBy('title')
                ->limit(static::MAX_SUGGESTIONS)
                ->asArray()
                ->all();
        
        return $list;       
    }

}
