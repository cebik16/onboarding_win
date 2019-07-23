<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\imagine\Image;

class ProjectForm extends Model
{
    public $project;
    
    public function save()
    {
    
        if ($this->validate()) {
    
            return $this->project->save();
        } else {
            VarDumper::dump($this->getErrors(), 10, true);
            exit;
    
        }
        
        return NULL;
    }
}
