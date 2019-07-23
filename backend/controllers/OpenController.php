<?php
    namespace backend\controllers;

    use common\models\Task;
    use Yii;
    use backend\components\Controller;
    use yii\helpers\VarDumper;
    use yii\web\NotFoundHttpException;
    use common\models\User;

    class OpenController extends Controller
    {
    
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['access']['rules'][] = [
                'actions' => [
                    'open/*',
                    'avatar',
                    'file'
                ],
                'allow' => true,
                'roles' => ['@']
            ];
            $behaviors['verbs']['actions'] = [
                'open'  => ['GET'],
            ];
        
            return $behaviors;
        }
        
        public function actionAvatar($id)
        {
            $this->layout = NULL;
            if ($model = User::findOne($id)) {
                if (file_exists($model->getAvatarFilepath())) {
                    header('Content-Type: ' . $model->avatar_mime_type);
                    header('Content-Disposition: inline; filename="' . $model->avatar . '"');
                    $content = file_get_contents($model->getAvatarFilepath());
                    if ($model->avatar_size) {
                        $size = $model->avatar_size;
                    } else {
                        $size = strlen($content);
                    }
                    header('Content-Length: ' . $size);
                    die($content);
                } else {
                    throw new NotFoundHttpException('The file does not exist');
                }
            } else {
                throw new NotFoundHttpException('The requested page does not exist');
            }
        }
    
        public function actionFile($id, $v)
        {
            $this->layout = NULL;
            if ($model = Task::findOne($id)) {
                if (file_exists($model->getAttachmentFilepath())) {
                    header('Content-Type: ' . $model->attachment_mime_type);
                    header('Content-Disposition: inline; filename="' . $model->attachment . '"');
                    $content = file_get_contents($model->getAttachmentFilepath());
                    if ($model->attachment_size) {
                        $size = $model->attachment_size;
                    } else {
                        $size = strlen($content);
                    }
                    header('Content-Length: ' . $size);
                    die($content);
                } else {
                    throw new NotFoundHttpException('The file does not exist');
                }
            } else {
                throw new NotFoundHttpException('The requested page does not exist');
            }
        }
    }