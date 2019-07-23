<?php
    
    
    namespace common\models;
    
    use Yii;
    use yii\behaviors\TimestampBehavior;
    use yii\db\ActiveRecord;
    use yii\helpers\VarDumper;

    /**
     * @property mixed task_id
     * @property  user_id
     */
    class Comment extends ActiveRecord
    {
        public static function tableName()
        {
            return '{{%comment}}';
        }
    
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
                [['user_id', 'task_id'], 'safe'],
                ['text', 'required'],
                ['text', 'string']
            ];
        }
    
    
        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'text' => 'Comment'
            ];
        }
    
    }