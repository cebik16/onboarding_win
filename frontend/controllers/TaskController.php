<?php
    
    namespace frontend\controllers;
    
    use backend\models\TaskForm;
    use backend\models\TaskSearch;
    use common\models\Comment;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\data\ArrayDataProvider;
    use yii\helpers\ArrayHelper;
    use yii\helpers\VarDumper;
    use yii\web\NotFoundHttpException;
    use yii\web\ForbiddenHttpException;
    use frontend\components\Controller;
    use common\models\Project;
    use common\models\User;
    use common\models\Task;
    
    class TaskController extends Controller
    {
        public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['access']['rules'][] = [
                'actions' => [
                    'index',
                    'view',
                    'update',
                    'change-status',
                    'add-comment'
                ],
                'allow' => true,
                'roles' => ['@'],
            ];
            $behaviors['access']['rules'][] = [
                'actions' => [
                    'create',
                    'delete',
                ],
                'allow' => true,
                'roles' => [User::$roles[User::ROLE_ADMIN]],
            ];
            $behaviors['verbs']['actions'] = [
                'index' => ['GET'],
                'view' => ['GET'],
                'create' => ['GET', 'POST'],
                'update' => ['GET', 'PUT', 'POST'],
                'delete' => ['POST', 'DELETE'],
            ];
            
            return $behaviors;
        }
        
        public function actionIndex()
        {
            $searchModel = new TaskSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->id);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
        
        public function actionView($id)
        {
            /** @var Task $task */
//            $task = Task::find()
//                ->joinWith(['comments'])
//                ->where(['task.id' => $id])
//                ->one();

            $task = Task::find()
                ->where(['id' => $id])
                ->with(['comments' => function($q){
                    $q->orderBy(['id' => SORT_DESC]);
                }])
                ->one();
            
            $comment = $this->createComment();
            
            $dataComments = new ArrayDataProvider([
                'allModels' => $task->comments,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
            
            return $this->render('view', [
                'model' => $task,
                'dataComments' => $dataComments,
                'comment' => $comment,
            ]);
        }
        
        public function actionUpdate($id)
        {
            $model = $this->findModel($id);
            
            if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post()) && $model->save() /*isset(Yii::$app->request->post()->status)*/) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
        
        protected function findModel($id)
        {
            if (($model = Task::findOne($id)) !== NULL) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        
        public function createComment(): Comment
        {
            $comment = new Comment();
            if (Yii::$app->request->isPost
                && isset(Yii::$app->request->post()['Comment'])
                && $comment->load(Yii::$app->request->post())
                && $comment->validate()
                && $comment->save()) {
                
//                 Yii::$app->user->setFlash('commentSubmitted', 'Thank you...');
                 $this->refresh();
             }
            return $comment;
        }
        
        public function actionAddComment()
        {
            $this->createComment();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }