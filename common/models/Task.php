<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\VarDumper;

/* @var integer $status *
 * /* @var integer $status * @property string $attachmentFilename
 * /* @var integer $status * @property null $attachmentUrl
 * /* @var integer $status * @property string $projectName
 * @property mixed               $attachmentFilepath
 * @property null                $attachmentUrl
 * @property string              $attachmentFilename
 * @property mixed               id
 * @property mixed               attachment_extension
 * @property mixed               attachment
 * @property \yii\db\ActiveQuery $comment
 * @property \yii\db\ActiveQuery $project
 * @property \yii\db\ActiveQuery $comments
 * /* @var integer $status * @property mixed $attachmentFilepath
 * /* @var integer $status
 */
class Task extends ActiveRecord
{

//    public $project;
    
    const STATUS_TO_DO = 0;
    const STATUS_IN_PROGRESS = 1;
    const STATUS_DONE = 2;
    
    public static $statuses = [
        self::STATUS_TO_DO => 'To do',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_DONE => 'Done',
    ];
    
    public static function tableName()
    {
        return '{{%task}}';
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
    
    public function attributeLabels()
    {
        return [
            'project.name' => 'Project Name',
        ];
    }
    
    public function rules()
    {
        return [
            [['name', 'description', 'status', 'user_id', 'project_id'], 'required'],
            ['status', 'default', 'value' => self::STATUS_TO_DO],
            ['status', 'in', 'range' => [self::STATUS_TO_DO, self::STATUS_IN_PROGRESS, self::STATUS_DONE]],
            
            [['attachment', 'attachment_extension', 'attachment_mime_type'], 'string', 'max' => 255],
            ['attachment_size', 'number', /*'max' => 10*1024, 'min' => 1024*/],
            
            [['project_id', 'user_id', 'status'], 'integer'],
        ];
    }
    
    public function getAttachmentUrl()
    {
        if ($this->attachment) {
            return Url::to(['/open/file', 'id' => $this->id, 'v' => time()]);
        }
        return NULL;
    }
    
    
    public function getAttachmentFilepath()
    {
        return Yii::getAlias('@storage/tasks_attachment/' . $this->attachmentFilename);
    }
    
    /**
     * @return string
     */
    public function getAttachmentFilename(): string
    {
        return $this->id . '.' . $this->attachment_extension;
    }
    
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }
    
    public function getComments(): ActiveQuery
    {
        return $this->hasMany(Comment::class, ['task_id' => 'id']);
    }
    
    public function getComment(): ActiveQuery
    {
        return $this->hasOne(Comment::class, ['task_id' => 'id']);
    }
}