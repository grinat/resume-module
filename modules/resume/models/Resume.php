<?php
namespace app\modules\resume\models;

use yii\db\ActiveRecord;
use app\modules\resume\models\ResumeCompetence;
use yii\data\ActiveDataProvider;

/**
 * Resume model
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 */
class Resume extends ActiveRecord{
    
    public static function tableName()
    {
        return '{{%resume}}';
    }
    
    public function rules() {
        return [
            ['title', 'trim'],
            [['title','description'], 'required'],
            [['title','description'], 'app\modules\resume\validators\PurifyFilter'],
            [['title','description'], 'string', 'min' => 3, 'max' => 200],
            [['description'], 'string', 'min' => 3],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Описание'
        ];
    }
    
    public function getResumeCompetencies() {
        return $this->hasMany(ResumeCompetence::className(), ['resume_id'=>'id']);
    }
    
    public function search()
    {
        $query = static::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $query->with('resumeCompetencies');
        
        return $dataProvider;
    }
}
