<?php

use yii\helpers\Html;
use common\widgets\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;

//$GLOBALS['blocksCount'] = Block::find()->count();

?>
<div class="project-index">
<!--    --><?php //echo $this->render('_tabs', ['action' => $this->context->action->id]); ?>


    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span>', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                'attribute' => 'start_date',
                'format' => 'date',
                'filter' => false
            ],
            [
                'attribute' => 'created_at',
                'filter' => false,
                'format' => 'datetime',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
            ],
        ],
    ]); ?>
</div>
