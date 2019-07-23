<?php $formatter = \Yii::$app->formatter; ?>
<hr>
<div class="media">
    <p class="pull-right">
    <small><?= Yii::$app->formatter->format($comment->created_at, 'relativeTime') ?></small>
    </p>
    <div class="media-body">
        <?= $comment->text?>
    </div>
</div>