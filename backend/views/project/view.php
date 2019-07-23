<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\Pjax;

use common\models\ProjectBlock;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


Yii::$app->formatter->nullDisplay = '';
$this->registerCss("
    .panel {
        margin-bottom: 0px;
    }"
);

?>

<div class="project-view">
	<div class="form-view">
		<div class="row">
			<div class="col-sm-8">                
				<h1> 
                    <?= Html::encode($this->title) ?>
                </h1>
                
			</div>
			<div class="col-sm-4">	
				<p class="pull-right">
                    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    
                    <?= /*Html::a('Export', ['export/index', 'id' => $model->id], ['class' => 'btn btn-default', 'target' => '_blank'])*/'' ?>

					<?= Html::a('Delete', ['delete', 'id' => $model->id], [
						'class' => 'btn btn-danger',
						'data' => [
							'confirm' => 'Are you sure you want to delete this item?',
							'method' => 'post',
						],
					]) ?>
				</p>
            
            </div>
		</div>
        <div class="row">
            <div class="col-sm-12">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        'name',
                        'start_date',
                        'duration'
                    ]
                ]) ?>
            </div>
        </div>
	</div>
</div>
