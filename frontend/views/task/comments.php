<?php

/* @var $this \yii\web\View */
/* @var $model \common\models\User|\yii\db\ActiveRecord */
/* @var $isUpdate bool */
    
    use yii\widgets\ListView;
    
    ?>

<div>
    <?php
        $widget = ListView::begin([
            'dataProvider' => $comments,
            'itemView' => function($comment){
                return $this->render('_list_comments', ['comment' => $comment]);
            },
            'layout' => '{items}',
        ]);
    ?>
    <div id="content">
        <div class="list clr">
            <?php echo $widget->renderItems(); ?>
        </div>
        
        <?php echo $widget->renderPager(); ?>

    </div>
</div>
