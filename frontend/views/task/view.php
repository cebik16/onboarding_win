<?php
    
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\bootstrap\ActiveForm;
    use yii\widgets\DetailView;
    
    /* @var $this yii\web\View */
    /* @var $model common\models\User */
    
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
    <div class="task-view">

        <h1>Task: <?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            
            <?= Html::a('Delete', ['validate-delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'onclick' => 'return validateDelete(this);',
            ]) ?>
        </p>
        
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'project.name',
                [
                    'attribute' => 'status',
                    'value' => $model::$statuses[$model->status],
                ],
                [
                    'label' => 'Attachment',
                    'format' => 'html',
                    'value' => static function ($model) {
                        if ($model->attachment_mime_type !== NULL) {
                            if (strpos($model->attachment_mime_type, 'image') !== false) {
                                return Html::img($model->attachmentUrl, ['width' => 'auto', 'height' => 'auto']);
                            } else {
                                return Html::a('File', $model->attachmentUrl);
                            }
                        }
                        return NULL;
                    },
                ],
                'created_at:datetime',
            ],
        ]) ?>

    </div>

    <div class="task-view">
        <?= $this->render('comments', [
            'comments' => $dataComments,
        ]) ?>

    </div>

    <div class="task-view">
        <hr>
        <?php $form = ActiveForm::begin(['action' => ['task/add-comment']]); ?>
        <?= $form->field($comment, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->id])->label(false) ?>
        <?= $form->field($comment, 'task_id')->hiddenInput(['value' => $model->id])->label(false) ?>
        <?= $form->field($comment, 'text', [
                'inputTemplate' =>
                    '<div class="input-group">
                        {input}
                        <span class="input-group-btn">
                            <button class="btn btn-default "><span class="glyphicon glyphicon-send"></span></button>
                        </span>
                    </div>',
            ])
            ->textInput(['placeholder' => 'Add a comment ...'])
            ->label(false) ?>
        <?php ActiveForm::end(); ?>

    </div>

<?php
    $csrfParams = Yii::$app->request->csrfParam;
    $scsrfToken = Yii::$app->request->csrfToken;
    $url_delete = Url::to(['delete'], true);
    
    $js = <<<JS
function validateDelete(link){

var request = $.ajax({
    url: link.href,
    type: "get",
    dataType: "json"
})
.done(function (response, textStatus, jqXHR) {
    let r;
    if(response.hasProjects){
        r = confirm("The task already has some data entered. All his work will be lost. Are you sure you want to delete ?");
    }else{
        r = confirm("Are you sure you want to delete ?");
    }

    let action = new URL('$url_delete');
    action.searchParams.append('id', response.id);

    const postData = {"$csrfParams": "$scsrfToken"};
    
    if (r === true) {
        $.ajax({
            url: action.href,
            type: "post",
            dataType: "json"
        });
    }
    return false;
})
.fail(function (jqXHR, textStatus, errorThrown){
    alert(textStatus + ': '+ errorThrown);
    return false;
});
return false;
}
JS;
    $this->registerJs($js, View::POS_END);
?>