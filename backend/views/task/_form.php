<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\task */
/* @var $form yii\widgets\ActiveForm */

$task = $model->task;
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($task, 'name')->textInput() ?>
    
    <?= $form->field($task, 'description')->textarea(['rows' => '6']) ?>

    <?= $form->field($task, 'status')->dropDownList($task::$statuses) ?>
    
    <?= $form->field($task, 'user_id')->dropDownList($users, ['prompt' => 'Please select an user...', 'id' => 'users-id']) ?>
    
    <?= $form->field($task, 'project_id')->dropDownList($projects, ['prompt' => 'Please select a project...', 'id' => 'projects-id']) ?>

    <?= $form->field($model, 'attachment')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->task->isNewRecord ? 'Create' : 'Update', ['class' => $task->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
