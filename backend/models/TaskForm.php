<?php
    
    namespace backend\models;
    
    use Yii;
    use yii\base\Model;
    use yii\behaviors\TimestampBehavior;
    use yii\helpers\VarDumper;

    /**
     * @property mixed task
     */
    class TaskForm extends Model
    {
        public $attachment;
        public $task;
        
        public function behaviors()
        {
            return [
                [
                    'class' => TimestampBehavior::className(),
                    'createdAtAttribute' => 'created_at',
                    'updatedAtAttribute' => 'updated_at',
                ],
            ];
        }
        
        public function rules()
        {
            return [
                [['task'], 'safe'],
                ['attachment', 'file', 'skipOnEmpty' => true],
            ];
        }
    
        public function save()
        {
            if ($this->validate()) {
                return $this->task->save();
            } else {
                VarDumper::dump($this->getErrors(), 10, true);
                exit;
    
            }
            
            return NULL;
        }
        
        public function upload()
        {
            if (!empty($this->attachment)) {
                return $this->attachment->saveAs(Yii::$app->params['tasks_attachment_path'] . $this->task->id . '.' . $this->attachment->extension);
            }
            return true;
        }
    }
