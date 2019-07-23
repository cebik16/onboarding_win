<?php
    
    
namespace backend\models;
    
    
    use common\models\Project;
    use yii\data\ActiveDataProvider;

    class ProjectSearch extends Project
    {
        public $name;
    
        public function rules()
        {
            return [
//                [['name', 'description', 'start_date', 'duration'], 'safe', 'required'],
//                ['start_date', 'date', 'format' => 'php:Y-m-d'],
//                ['duration', 'integer'],
            ];
        }
    
        public function search($params = [])
        {
            $query = Project::find();
            
            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);
        
            if (!($this->validate() && $this->load($params))) {
                return $dataProvider;
            }
        
            foreach($this->attributes() as $attribute){
                if ($this->$attribute !== '') {
                    $query->andFilterWhere([
                        $attribute => $this->$attribute
                    ]);
                }
            }
            return $dataProvider;
        }
    
    }
