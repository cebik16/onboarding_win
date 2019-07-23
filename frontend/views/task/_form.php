<?php
    
    use common\models\Task;
    use yii\helpers\Html;
    use yii\web\View;
    use yii\widgets\ActiveForm;
    
    /* @var $this yii\web\View */
    /* @var $model common\models\task */
    /* @var $form yii\widgets\ActiveForm */
    
    $task = $model;
?>

<div class="task-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($task, 'name')->textInput(['disabled' => true]) ?>
    
    <?= $form->field($task, 'status')->dropDownList($task::$statuses) ?>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $task->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
