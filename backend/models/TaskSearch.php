<?php
    
    
    namespace backend\models;
    
    use common\models\Task;
    use yii\data\ActiveDataProvider;
    use yii\helpers\VarDumper;

    class TaskSearch extends Task
    {
        public $username;
    
        public function rules()
        {
            return [
                [['name', 'description', 'status', 'attachment', 'user_id', 'project_id'], 'safe'],
            ];
        }
    
        public function search($params = [], $user_id = NULL)
        {
            $query = Task::find();
            
            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);
            
            if($user_id !== NULL){
                $query->where(['user_id' => $user_id]);
            }
        
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