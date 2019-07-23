<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Update Task: ' . $model->task->name;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->task->name, 'url' => ['view', 'id' => $model->task->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'projects' => $projects,
        'isUpdate' => true
    ]) ?>

</div>
