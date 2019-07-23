<?php
    
    namespace backend\controllers;
    
    use Yii;
    use yii\helpers\VarDumper;
    use yii\web\NotFoundHttpException;
    use yii\web\ForbiddenHttpException;
    use backend\components\Controller;

    use backend\models\ProjectSearch;
    use common\models\Project;
    use common\models\User;
    use backend\models\ProjectForm;
    
    /**
     * PtojectsController implements the CRUD actions for Project model.
     */
    class ProjectController extends Controller
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
        
        /**
         * Lists all Project models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel = new ProjectSearch();
            
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            
            ]);
        }
        
        /**
         * Displays a single Project model.
         * @param string $id
         * @return mixed
         */
        public function actionView($id)
        {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
        
        /**
         * Creates a new Project model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new ProjectForm([
                'project' => new Project()
            ]);
    
            $model->scenario = 'create';
    
            if ($model->project->load(Yii::$app->request->post()) && $model->project->save()) {
                return $this->redirect(['view', 'id' => $model->project->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        
        /**
         * Updates an existing Project model.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param string $id
         * @return mixed
         */
        public function actionUpdate($id)
        {
            $model = new ProjectForm(['project' => $this->findModel($id)]);
    
            if ($model->project->load(Yii::$app->request->post()) && $model->project->save()) {
                return $this->redirect(['view', 'id' => $model->project->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        
        public function actionWorkspace($projectId, $blockId)
        {
            $project = $this->findModel($projectId);
            if (($block = Block::findOne($blockId)) === NULL) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            if (!Yii::$app->user->projectPermission('edit', $project)) {
                throw new ForbiddenHttpException('You don\'t have permissions to edit this project.');
            }
            $results = Block::find()->all();
            $blocks = [];
            foreach ($results as $item) {
                $blocks[$item->slug] = $item;
            }
            if (($model = ProjectBlock::findOne(['project_id' => $project->id, 'block_id' => $block->id])) === NULL) {
                $model = new ProjectBlock(['project_id' => $project->id, 'block_id' => $block->id]);
            }
            
            if (Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                if ($model->load($post) && $model->save()) {
                    Yii::$app->session->addNotification('success', $block->name . ' saved');
                    return $this->redirect(['workspace', 'projectId' => $model->project_id, 'blockId' => $model->block_id]);
                }
            }
            return $this->render('workspace', [
                'project' => $project,
                'block' => $block,
                'blocks' => $blocks,
                'model' => $model,
            ]);
        }
        
        public function actionRating($projectId, $blockId)
        {
            $project = $this->findModel($projectId);
            if (($block = Block::findOne($blockId)) === NULL) {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
            if (($model = ProjectBlock::findOne(['project_id' => $project->id, 'block_id' => $block->id])) === NULL) {
                $model = new ProjectBlock(['project_id' => $project->id, 'block_id' => $block->id]);
            }
            if ((Yii::$app->user->isAdmin() || Yii::$app->user->isCoach()) && Yii::$app->request->isPost) {
                $post = Yii::$app->request->post();
                if ($model->load($post) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->project_id]);
                }
            }
            return $this->render('rating-' . ((Yii::$app->user->isAdmin() or Yii::$app->user->isCoach()) ? 'form' : 'view'), [
                'model' => $model,
                'project' => $project,
                'block' => $block,
            ]);
        }
        
        public function actionExport($id)
        {
            $model = $this->findModel($id);
            if (Yii::$app->user->projectPermission('view', $model)) {
                $results = Block::find()->all();
                $blocks = [];
                $slugs = [];
                foreach ($results as $block) {
                    $blocks[$block->slug] = $block;
                    $slugs[$block->id] = $block->slug;
                }
                $projectBlocks = [];
                foreach ($model->blocks as $projectBlock) {
                    $projectBlocks[$slugs[$projectBlock->block_id]] = $projectBlock;
                }
                $pdf = $model->getPdf('S', $blocks, $projectBlocks);
                $filename = preg_replace('/[^A-Za-z0-9\-_]/', '', str_replace(' ', '_', $model->name)) . '-' . date('Y-m-d') . '.pdf';
                $output = $pdf->render();
                header("Content-type:application/pdf");
                header("Content-Disposition:inline;filename=" . $filename);
                die($output);
            } else {
                throw new \yii\web\ForbiddenHttpException('You don\'t have permissions to view this project');
            }
        }
        
        public function actionDelete($id)
        {
            $model = $this->findModel($id);
            if (!Yii::$app->user->projectPermission('delete', $model)) {
                throw new ForbiddenHttpException('You don\'t have permissions to delete this project.');
            }
            if ($model->delete()) {
                Yii::$app->session->addNotification('success', 'Project deleted');
            } else {
                Yii::$app->session->addNotification('error', 'Project NOT deleted');
            }
            return $this->redirect(['index']);
        }
        
        /**
         * Finds the Project model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param string $id
         * @return Project the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id)
        {
            if (($model = Project::findOne($id)) !== NULL) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
        
        private function buildVpTree(array &$elements, $parentId = 0)
        {
            $branch = [];
            
            foreach ($elements as $element) {
                if ($element->parent_id == $parentId) {
                    
                    if (Yii::$app->user->isAdmin() || Yii::$app->user->isCoach()) {
                        $selectProjects = Project::find()
                            ->where(['vp_tree_id' => $element->id])->count();
                    } else {
                        $selectProjects = Project::find()->joinWith('permissions')
                            ->Where([Project::tableName() . '.created_by' => Yii::$app->user->id])
                            ->orWhere([ProjectPermission::tableName() . '.user_id' => Yii::$app->user->id])
                            ->andwhere([Project::tableName() . '.vp_tree_id' => $element->id])
                            ->distinct()
                            ->count();
                    }
                    
                    
                    $elem = [
                        'name' => $element->name,
                    ];
                    if ($children = $this->buildVpTree($elements, $element->id)) {
                        $elem['children'] = $children;
                    }
                    $branch[$element->id] = $elem;
                    unset($element);
                }
            }
            return $branch;
        }
    }
