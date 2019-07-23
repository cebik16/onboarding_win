<?php
    
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;
    use yii\widgets\DetailView;
    
    /* @var $this yii\web\View */
    /* @var $model common\models\User */
    
    $this->title = $model->name;
    $this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;
?>
    <div class="task-view">
        
        <h1><?= Html::encode($this->title) ?></h1>
        
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
                'id',
                'name',
                [
                    'attribute' => 'status',
                    'value' => $model::$statuses[$model->status],
                ],
                [
                    'label' => 'attachment',
                    'format' => 'html',
                    'value' => static function($model){
                        if(strpos($model->attachment_mime_type, 'image')!==FALSE){
                            return Html::img($model->attachmentUrl, ['width' => 'auto', 'height' => 100]);
                        } else {
                            return Html::a('File', $model->attachmentUrl);
                        }
                    },
                ],
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    
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