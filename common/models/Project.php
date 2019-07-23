<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use kartik\mpdf\Pdf;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project".
 *
 * @property string  $id
 * @property string  $vp_tree_id
 * @property string  $name
 * @property string  $progress
 * @property string  $image
 * @property string  $image_extension
 * @property string  $image_mime_type
 * @property string  $image_size
 * @property string  $created_by
 * @property integer $created_at
 * @property string  $scoreBar
 * @property mixed   $imageFilepath
 * @property mixed   $blocks
 * @property mixed   $permissions
 * @property mixed   $createdBy
 * @property mixed   $documents
 * @property mixed   $businessUnit
 * @property null    $score
 * @property string  $imageFilename
 * @property integer $updated_at
 */
class Project extends ActiveRecord
{

    public static $stages = [
        0 => '',
        1 => 'Stage 1',
        2 => 'Stage 2'
    ];


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'start_date', 'duration'], 'safe'],
            [['name', 'description', 'start_date', 'duration'], 'required'],
            ['start_date', 'date', 'format' => 'php:Y-m-d'],
            ['duration', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'start_date' => 'Start Date',
            'duration' => 'Duration',
            'created_by' => 'Created By',
            'created_at' => 'Created On',
            'updated_at' => 'Updated On',
        ];
    }
}
