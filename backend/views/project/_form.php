<?php
    
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use kartik\date\DatePicker;
    use common\models\User;
    
    $project = $model->project;
?>


<div class="row">
    <div class="col-md-6">
        <?php $form = ActiveForm::begin(['options' => ['id' => 'projectform', 'enctype' => 'multipart/form-data']]); ?>
        
        <?= $form->field($model->project, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model->project, 'description')->textarea(['rows' => '6']) ?>
    
        <?= $form->field($model->project, 'start_date')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Select starting time ...'],
            'convertFormat' => true,
            'pluginOptions' => [
                'format' => 'yyyy-MM-d',
                'startDate' => 'd',
                'todayHighlight' => true
            ]
        ]) ?>
    
        <?= $form->field($model->project, 'duration')->textInput(['type' => 'number', 'placeholder' => '(days)', 'min' => 1]) ?>


        <div class="form-group">
            <?= Html::submitButton($model->project->isNewRecord ? 'Create' : 'Update', ['class' => $model->project->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        
        <?php ActiveForm::end(); ?>
    </div>

</div>


