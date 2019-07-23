<?php
    
    use common\models\User;
    use yii\helpers\Html;
    use yii\web\View;
    
    /* @var $this yii\web\View */
    /* @var $model common\models\User */
    
    $this->title = 'Update Task: ' . $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">
    
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' => true
    ]) ?>

</div>
