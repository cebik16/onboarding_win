<?php

namespace backend\controllers;

use backend\models\TaskForm;
use backend\models\TaskSearch;
use common\models\Project;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use backend\components\Controller;
use common\models\Task;
use yii\web\UploadedFile;

class TaskController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access']['rules'][] = [
            'actions' => [
                'index',
                'create',
                'view',
                'update',
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
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
    
    public function actionCreate()
    {
        $model = new TaskForm([
            'task' => new Task(['status' => Task::STATUS_TO_DO]),
        ]);
        
        if (($postData = Yii::$app->request->post()) && $model->load($postData, 'TaskForm')) {
            
            $model->attachment = UploadedFile::getInstance($model, 'attachment');
    
            if (!empty($model->attachment)) {
    
                $postData['Task']['attachment'] = $model->attachment->baseName . '.' . $model->attachment->extension;
                $postData['Task']['attachment_extension'] = $model->attachment->extension;
                $postData['Task']['attachment_mime_type'] = $model->attachment->type;
                $postData['Task']['attachment_size'] = $model->attachment->size;
                
            }
            
            if ($model->task->load($postData, 'Task') && $model->save() && $model->upload()) {
                return $this->redirect(['view', 'id' => $model->task->id]);
            }
        }
    
        $usersArray = ArrayHelper::map(User::find()
            ->orderBy(['first_name' => SORT_ASC,'last_name' => SORT_ASC])
            ->all(), 'id', 'name');
        
        $projectsArray = ArrayHelper::map(Project::find()
            ->orderBy(['name' => SORT_ASC])
            ->all(), 'id', 'name');
        
        return $this->render('create', [
            'model' => $model,
            'users' => $usersArray,
            'projects' => $projectsArray
        ]);
    }
    
    public function actionUpdate($id)
    {
        $model = new TaskForm([
            'task' => $this->findModel($id)
        ]);
    
        if (Yii::$app->request->isPost && ($postData = Yii::$app->request->post()) && $model->load($postData, 'TaskForm')) {
            
            $model->attachment = UploadedFile::getInstance($model, 'attachment');
            
            if (!empty($model->attachment)) {
                $postData['Task']['attachment'] = $model->attachment->baseName . '.' . $model->attachment->extension;
                $postData['Task']['attachment_extension'] = $model->attachment->extension;
                $postData['Task']['attachment_mime_type'] = $model->attachment->type;
                $postData['Task']['attachment_size'] = $model->attachment->size;
            }
            
            if ($model->task->load($postData, 'Task') && $model->save() && $model->upload()) {
                return $this->redirect(['view', 'id' => $model->task->id]);
            }
        }
    
        $usersArray = ArrayHelper::map(User::find()
            ->orderBy(['first_name' => SORT_ASC,'last_name' => SORT_ASC])
            ->all(), 'id', 'name');
    
        $projectsArray = ArrayHelper::map(Project::find()
            ->orderBy(['name' => SORT_ASC])
            ->all(), 'id', 'name');
        
        return $this->render('update', [
            'model' => $model,
            'users' => $usersArray,
            'projects' => $projectsArray
        ]);
    }
}