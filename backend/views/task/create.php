<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create Task';
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create'
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'projects' => $projects,
    ]) ?>

</div>
